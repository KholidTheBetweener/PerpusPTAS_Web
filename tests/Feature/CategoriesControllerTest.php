<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Categories;
use App\Models\Admin;

class CategoriesControllerTest extends TestCase
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
    public function test_categories_index(): void
    {
        Categories::factory(6)->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
        $response->assertViewHas('kategori');
    }
    public function test_categories_create_form(): void
    {
        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.create');
    }
    public function test_categories_store(): void
    {
        $data = [
            'name' => 'Test Category'
        ];

        $response = $this->post(route('categories.store'), $data);

        $response->assertRedirect(route('categories.index'));
        
        $response->assertSessionHas('success', 'Kategori has been created successfully.');
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }
    public function test_categories_edit_form(): void
    {
        $category = Categories::factory()->create();

        $response = $this->get(route('categories.edit', $category));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.edit');
        $response->assertViewHas('category', $category);
    }
    public function test_categories_update(): void
    {
        $category = Categories::factory()->create();

        $data = [
            'name' => 'Updated Name'
        ];

        $response = $this->put(route('categories.update', $category), $data);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori Has Been updated successfully');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name'
        ]);
    }
    public function test_categories_delete(): void
    {
        $category = Categories::factory()->create();
        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori has been deleted successfully');

        $this->assertDatabaseMissing('categories', ['id' => $category]);
    }
}
