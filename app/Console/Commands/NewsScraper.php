<?php

namespace App\Console\Commands;

use App\Services\NewsScraperService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class NewsScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hacker-news-scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data form Hacker News';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://news.ycombinator.com/';
        $client = new Client();

        $service = new NewsScraperService($url, $client);

        $this->info($service->filterAndStoreData());
    }
}
