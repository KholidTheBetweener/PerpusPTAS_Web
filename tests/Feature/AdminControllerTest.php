<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $admin = Admin::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        $this->actingAs($admin, guard: 'admin');
    }
    public function test_admin_index(): void
    {
        Admin::factory(10)->create();

        $response = $this->get(route('admin.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin.index');
        $response->assertViewHas('admins');
    }
    public function test_admin_create_form(): void
    {
        $response = $this->get(route('admin.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin.create');
    }
    public function test_admin_store(): void
    {
        $data = [
            'username' => 'John',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->post(route('admin.store'), $data);
        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success', 'Admin has been created successfully.');

        $this->assertDatabaseHas('admins', ['email' => 'john.doe@example.com']);
    }
    public function test_admin_edit_form(): void
    {
        $user = Admin::factory()->create();

        $response = $this->get(route('admin.edit', $user));

        $response->assertStatus(200);
        $response->assertViewIs('admin.admin.edit');
        $response->assertViewHas('admin', $user);
    }
    public function test_admin_update(): void
    {
        $user = Admin::factory()->create();

        $data = [
            'username' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'password' => 'qwerty12345',
        ];

        $response = $this->put(route('admin.update', $user), $data);

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success', 'Admin Has Been updated successfully');

        $this->assertDatabaseHas('admins', [
            'id' => $user->id,
            'username' => 'Updated Name',
            'email' => 'updated.email@example.com',
        ]);
    }
    public function test_admin_delete(): void
    {
        $user = Admin::factory()->create();

        $response = $this->delete(route('admin.destroy', $user));

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success', 'Admin has been deleted successfully');

        $this->assertDatabaseMissing('admins', ['id' => $user->id]);
    }
}
