<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Jobs\UrlProcessor;
use App\Models\Domain;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class URLController extends Controller
{
    /**
     * @return
     */
    public function create()
    {
        return view('urls.create')->with('message', session('message'));
    }

    /**
     * @param UrlRequest $request
     * @return
     */
    public function store(UrlRequest $request)
    {
        try {
            $urls = explode("\n", trim($request->validated()['urls']));

            $validUrls = array_filter($urls, function ($url) {
                return filter_var(trim($url), FILTER_VALIDATE_URL);
            });

            if (empty($validUrls)) {
                return back()->withErrors(['urls' => 'No valid URLs provided.']);
            }
            // Dispatching the job with the valid URLs
            dispatch(new UrlProcessor($validUrls));
            return redirect()->route('urls.create')->with('message', 'URLs are being processed.');
        } catch (\Exception $e) {
            Log::error('Error storing URLs: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while processing. Please try again.']);
        }
    }


    /**
     * @param Request $request
     * @return
     */

     public function show(Request $request)
     {
         try {
             $search = $request->input('search');
             $sort = $request->input('sort', 'url'); // default sort by url
             $order = $request->input('order', 'asc'); // default order ascending

             $query = UrlModel::with('domain')
                 ->when($search, function ($query, $search) {
                     return $query->where('url', 'like', "%$search%")
                                 ->orWhereHas('domain', function ($query) use ($search) {
                                     $query->where('name', 'like', "%$search%");
                                 });
                 });

             if ($sort === 'domain.name') {
                 $query->join('domains', 'urls.domain_id', '=', 'domains.id')
                       ->select('urls.*') // Avoid selecting everything from the joined table
                       ->orderBy('domains.name', $order);
             } else {
                 $query->orderBy($sort, $order);
             }

             $urls = $query->paginate(10);

             return view('urls.show', compact('urls', 'search', 'sort', 'order'));
         } catch (\Exception $e) {
             Log::error('Error showing URLs: ' . $e->getMessage());
             return back()->withErrors(['error' => 'An error occurred while retrieving URLs. Please try again.']);
         }
     }


}
