<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    public function test_index_method_returns_valid_response()
    {
        $response = $this->get('/api/news');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'link',
                    'points',
                    'date_created',
                ]
            ]
        ]);
    }

    public function test_delete_method_soft_deletes_news_item()
    {
        $newsItem = News::factory()->create();

        $user = User::factory()->make(['username' => 'test']);

        $this->actingAs($user)->get("/news/delete/{$newsItem->id}");

        $this->assertSoftDeleted('news', ['id' => $newsItem->id]);
    }
}
