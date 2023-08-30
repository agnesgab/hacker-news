<?php

namespace App\Services;

use App\Models\News;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class NewsScraperService
{
    private string $url;
    private Client $client;

    public function __construct(string $url, Client $client)
    {
        $this->url = $url;
        $this->client = $client;
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function filterAndStoreData(): string
    {
        $crawler = new Crawler($this->getHtmlContent());

        try {
            $crawler->filter('.athing')->each(function ($node) {
                $this->storeData($node);
            });

            return 'Scraping and storing completed.';
        } catch (\Exception $e) {
            return 'An error occurred during scraping and storing.';
        }
    }

    /**
     * Get data and HTML content from the URL.
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHtmlContent()
    {
        $request = $this->client->request('GET', $this->url);

        return $request->getBody();
    }

    /**
     * Storing filtered title, link, points and time posted.
     *
     * @param $node
     * @return void
     */
    public function storeData($node)
    {
        $title = $node->filter('.titleline a')->text('Title');
        $link = $node->filter('.titleline a')->attr('href');
        $points = filter_var($node->nextAll()->filter('.subline > .score')->text(0), FILTER_SANITIZE_NUMBER_INT);
        $datetimeCreated = $node->nextAll()->filter('.subline > .age')->attr('title');

        News::updateOrCreate(
            ['link' => $link],
            ['title' => $title, 'date_created' => $datetimeCreated, 'points' => $points],
        );

        News::where('link', $link)->update(['points' => $points]);
    }
}
