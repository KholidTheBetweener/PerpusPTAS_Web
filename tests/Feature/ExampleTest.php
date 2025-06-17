<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_web_profile(): void
    {
        $response = $this->get('/profile');

        $response->assertStatus(200);
    }
    public function test_web_about(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
    public function test_web_contact(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
    public function test_web_download(): void
    {
        $response = $this->get('/download');

        $response->assertStatus(200);
    }
}
