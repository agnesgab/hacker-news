<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_middleware_returning_correct_response_when_user_not_authenticated(): void
    {
        $response = $this->get('/news');

        $response->assertStatus(302);
    }

    public function test_not_authenticated_user_is_required_to_login()
    {
        $response = $this->get('/news');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_cannot_view_registration_form()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_cannot_view_login_form()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_can_view_news_page()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/news');

        $response->assertSuccessful();
        $response->assertViewIs('news.news-index');
    }
}
