<?php

namespace App\Jobs;

use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UrlProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $urls;

    /**
     * Create a new job instance.
     */
    public function __construct($urls)
    {
        $this->urls = $urls;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->urls as $url) {
            try {
                $parsedUrl = parse_url($url);
                $host = $parsedUrl['host'] ?? '';

                if ($host) {
                    $domain = Domain::firstOrCreate(['name' => $host]);
                    $domain->urls()->updateOrCreate(['url' => $url]);
                } else {
                    Log::warning('Host not found for URL: ' . $url); // Log if host not found
                }
            } catch (\Exception $e) {
                Log::error('Error processing URL ' . $url . ': ' . $e->getMessage());
            }
        }
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return md5(implode(',', $this->urls));
    }
}
