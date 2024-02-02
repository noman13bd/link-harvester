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
                return back()->withErrors(['urls' => 'invalid URLs.']);
            }
            // dispatch job
            dispatch(new UrlProcessor($validUrls));
            return redirect()->route('urls.create')->with('message', 'URLs will be  processed shortly.');
        } catch (\Exception $e) {
            Log::error('URLs not saved: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error!!!']);
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
             $sort = $request->input('sort', 'url');
             $order = $request->input('order', 'desc');
             $query = Url::with('domain')
                ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('url', 'like', "%$search%")
                            ->orWhereHas('domain', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                    });
                });
            //  $rawSql = $query->toSql();
             if ($sort === 'domain.name') {
                 $query->join('domains', 'urls.domain_id', '=', 'domains.id')
                       ->select('urls.*')
                       ->orderBy('domains.name', $order);
             } else {
                 $query->orderBy($sort, $order);
             }
             $urls = $query->paginate(10);
            //  dd($urls);
             return view('urls.show', compact('urls', 'search', 'sort', 'order'));
         } catch (\Exception $e) {
            Log::error('URLs display error: ' . $e->getMessage());
             return back()->withErrors(['error' => 'Error!!!']);
         }
     }


}
