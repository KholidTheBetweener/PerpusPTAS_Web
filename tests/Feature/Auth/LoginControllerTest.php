<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_login_form(): void
    {
        $response = $this->get('/admin');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
    public function test_admin_login_succesfully(): void
    {
        $user = Admin::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/admin', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user, guard: 'admin');
    }
    public function test_user_login_form(): void
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
    public function test_user_login_succesfully(): void
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@dev.com',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }
}
