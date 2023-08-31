<?php

namespace Tests\Feature;

use App\Services\NewsScraperService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

class NewsScraperServiceTest extends TestCase
{
    public function test_instance_of_news_scraper_service_is_created()
    {
        $httpClient = Mockery::mock(Client::class);
        $httpClient->shouldReceive('request')->andReturn(new Response(
            200,
            [],
            file_get_contents(__DIR__ . '/test-index.html')
        ));

        $newsScraperService = new NewsScraperService('https://news.ycombinator.com/', $httpClient);

        $this->assertInstanceOf(NewsScraperService::class, $newsScraperService);
    }

    public function test_html_content_is_fetched_from_url()
    {
        $httpClient = $this->createMock(Client::class);
        $url = 'https://news.ycombinator.com/';

        $newsScraperService = new NewsScraperService($url, $httpClient);
        $htmlContent = $newsScraperService->getHtmlContent();

        $this->assertInstanceOf(StreamInterface::class, $htmlContent);
    }
}
