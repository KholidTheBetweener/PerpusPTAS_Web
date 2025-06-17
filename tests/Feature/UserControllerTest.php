<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;
use App\Models\Book;
use App\Models\Rent;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UserControllerTest extends TestCase
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
    public function test_user_search(): void
    {
        User::factory(10)->create();

        $response = $this->get(route('user.search', ['q' => 'a']));
        //dd($response);
        $response->assertStatus(200)->assertJsonStructure([
                '*' =>[
                        'id',
                        'name',
                        'email',
                    ]
        ]);
    }
    public function test_user_index(): void
    {
        $user = User::factory(10)->create();
        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.user.index');
        $response->assertViewHas('users');
    }
    public function test_user_show(): void
    {
       $user = User::factory()->create();

        $response = $this->get(route('user.show', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.show');
        $response->assertViewHas('user');
    }
    public function test_user_photo_profile(): void
    {
        Storage::fake('local');
        $data = User::factory()->create();
        $response = $this->post(route('user.photo', $data), [
            'photo'=>UploadedFile::fake()->image('photo.jpg')
        ]);

        $response->assertRedirect(route('user.show', $data->id));
        $response->assertSessionHas('success', 'User photo has been uploaded.');
    }
    public function test_user_create_form(): void
    {
        $response = $this->get(route('user.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.user.create');
    }
    public function test_user_store(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->post(route('user.store'), $data);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', 'User has been created successfully.');

        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }
    public function test_user_edit_form(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.edit', $user));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.edit');
        $response->assertViewHas('user', $user);
    }
    public function test_user_update(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'password' => 'qwerty12345',
        ];

        $response = $this->put(route('user.update', $user), $data);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', 'User Has Been updated successfully');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
        ]);
    }
    public function test_user_delete(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('user.destroy', $user));

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', 'User has been deleted successfully');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
    public function test_cannot_delete_user_has_rent_history(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $rent = Rent::factory()->create([
            'books_id' => $book->id,
            'users_id' => $user->id,
        ]);
        $response = $this->delete(route('user.destroy', $user));
        $count = $rent->count();
        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', 'Ada '. $count .' Catatan Peminjaman untuk akun ini dan catatan perlu dihapus dulu sebelum akun bisa dihapus');

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}
