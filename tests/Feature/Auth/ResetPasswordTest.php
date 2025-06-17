<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Auth\Notifications\ResetsPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;

class ResetPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithFaker, RefreshDatabase;
    public function testDisplaysPasswordResetRequestFormUser()
    {
        $response = $this->get('password/reset');
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.email');
    }
    /**
     * Sends the password reset email when the user exists.
     *
     * @return void
     */
    public function testSendsPasswordResetEmailUser()
    {
        Notification::fake();
        $user = User::factory()->create();
        //$this->expectsNotification($user, ResetPassword::class);
        $response = $this->post('password/email', ['email' => $user->email]);
        $response->assertStatus(302);
        $response->assertSessionHas('status', 'We have emailed your password reset link.');
        Notification::assertSentTo($user, ResetPassword::class);
    }
    /**
     * Does not send a password reset email when the user does not exist.
     *
     * @return void
     */
    public function testDoesNotSendPasswordResetEmailUser()
    {
        //$this->doesntExpectJobs(ResetPassword::class);
        $response = $this->post('password/email', ['email' => 'invalid@email.com']);
        $response->assertStatus(302);
    }
    /**
     * Displays the form to reset a password.
     *
     * @return void
     */
    public function testDisplaysPasswordResetFormUser()
    {
        $response = $this->get('/password/reset/token');
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.reset');
    }
    /**
     * Allows a user to reset their password.
     *
     * @return void
     */
    public function testChangesAUsersPasswordUser()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);
        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertSessionHas('status', 'Your password has been reset.');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
    
    public function testDisplaysPasswordResetRequestFormAdmin()
    {
        $response = $this->get('/admin/password/reset');
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.email');
    }
    /**
     * Sends the password reset email when the user exists.
     *
     * @return void
     */
    public function testSendsPasswordResetEmailAdmin()
    {
        $admin = Admin::factory()->create();
        //$this->expectsNotification($user, ResetPassword::class);
        $response = $this->post('/admin/password/email', ['email' => $admin->email]);
        $response->assertStatus(302);
        $response->assertSessionHas('status', 'We have emailed your password reset link.');
    }

    /**
     * Does not send a password reset email when the user does not exist.
     *
     * @return void
     */
    public function testDoesNotSendPasswordResetEmailAdmin()
    {
        //$this->doesntExpectJobs(ResetPassword::class);
        $response = $this->post('/admin/password/email', ['email' => 'invalid@email.com']);
        $response->assertStatus(302);
    }
    /**
     * Displays the form to reset a password.
     *
     * @return void
     */
    public function testDisplaysPasswordResetFormAdmin()
    {
        $response = $this->get('/admin/password/reset/token');
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.reset');
    }

    /**
     * Allows a user to reset their password.
     *
     * @return void
     */
    public function testChangesAUsersPasswordAdmin()
    {
        $admin = Admin::factory()->create();
        //$this->actingAS($admin, guard: 'admin');
        $token = Password::createToken($admin);
        $response = $this->post('/admin/password/reset', [
            'token' => $token,
            'email' => $admin->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $this->assertTrue(Hash::check('password', $admin->fresh()->password));
    }
    public function test_show_confirm_user(): void
    {
        $response = $this->post(route('password.confirm'));
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
