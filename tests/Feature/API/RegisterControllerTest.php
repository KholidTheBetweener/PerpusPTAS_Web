<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@dev.com',
            'password' => 'password',
            'c_password' => 'password',
        ]);
        // assert that the response is a 200 with a json structure containing an access token and a token type
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'=>[
                    'token',
                    'name'
                ]
            ]);

        // assert that the user was created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'test@dev.com',
        ]);
    }
    public function test_user_fail_register_validation_error(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@dev.com',
            'password' => 'password',
            'c_password' => 'password2',
        ]);
        // assert that the response is a 200 with a json structure containing an access token and a token type
        $response->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message',
            ]);

    }
    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);

        // send json post request to login with correct credentials
        $response = $this->postJson('/api/login', [
            'email' => 'test@dev.com',
            'password' => 'password',
        ]);

        // assert that the response is a 200 with a json structure containing an access token and a token type
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' =>[
                    'token',
                    'name'
                ]
            ]);
    }
    public function test_user_fail_login_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);

        // send json post request to login with correct credentials
        $response = $this->postJson('/api/login', [
            'email' => 'test@dev.com',
            'password' => 'password2',
        ]);

        // assert that the response is a 200 with a json structure containing an access token and a token type
        $response->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }
    public function test_user_reset_password(): void
    {
        User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->postJson('/api/forgot-password', [
            'email' => 'test@dev.com'
        ]);
        //dd($response);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }
    public function test_user_reset_password_fail(): void
    {
        User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->postJson('/api/forgot-password');
        //dd($response);
        $response->assertStatus(404)
            ->assertJsonStructure([
                'email'
            ]);
    }
    public function test_user_can_logout(): void
    {
        User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);

        // send json post request to login with correct credentials
        $response = $this->postJson('/api/login', [
            'email' => 'test@dev.com',
            'password' => 'password',
        ]);
        $response = $this->postJson('/api/logout');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
