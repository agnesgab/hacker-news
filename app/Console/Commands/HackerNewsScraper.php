<?php

namespace App\Console\Commands;

use App\Models\News;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class HackerNewsScraper extends Command
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

        // Data from the URL
        $request = $client->request('GET', $url);

        // HTML content
        $html = $request->getBody();

        $crawler = new Crawler($html);

        // Filtering title, link, points and time posted
        $crawler->filter('.athing')->each(function ($node) {
            $title = $node->filter('.titleline a')->text('Title');
            $link = $node->filter('.titleline a')->attr('href');
            $points = filter_var($node->nextAll()->filter('.subline > .score')->text(0), FILTER_SANITIZE_NUMBER_INT);
            $datetimeCreated = $node->nextAll()->filter('.subline > .age')->attr('title');

            News::updateOrCreate(
                ['link' => $link],
                ['title' => $title, 'date_created' => $datetimeCreated, 'points' => $points],
            );

            News::where('link', $link)->update(['points' => $points]);
        });

        $this->info('Scraping and storing completed.');
    }
}
