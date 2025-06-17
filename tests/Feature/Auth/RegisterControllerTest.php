<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_register_form(): void
    {
        $response = $this->get('/admin/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }
    public function test_admin_register_succesfully(): void
    {
        $response = $this->post('/admin/register', [
            'name' => 'testdev',
            'email' => 'test@dev.com',
            'password' => 'testpassword123',
            'password_confirmation' => 'testpassword123',
        ]);

        $response->assertRedirect('/admin');
    }
    public function test_user_register_form(): void
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }
    public function test_user_register_succesfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'testdev',
            'email' => 'test@dev.com',
            'password' => 'testpassword123',
            'password_confirmation' => 'testpassword123',
        ]);

        $response->assertRedirect('/home');
    }
}
