<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTests extends TestCase
{
    public function test_api_get_users_returns_a_successful_response():void
    {
        $response = $this -> get('/api/v1/users');
        $response -> assertStatus(200);
    }

    public function test_api_post_users_returns_a_successful_response():void
    {
        $response = $this -> postJson('/api/v1/users',[
            'id' => '821111',
            'auth_string' => 'bobsbobs',
            'is_receiving_news_notifications' => 'true',
            'is_receiving_performance_notifications' => 'false',
        ]);
        $response -> assertStatus(200);
    }

    public function test_api_delete_users_returns_a_successful_response():void
    {
        $response = $this -> deleteJson('/api/v1/users',['id' => '821111']);
        $response -> assertStatus(200);
    }

    public function test_api_get_performances_returns_a_successful_response():void
    {
        $response = $this -> get('/api/v1/performances');
        $response -> assertStatus(200);
    }
}
