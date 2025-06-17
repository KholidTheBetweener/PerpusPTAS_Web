<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_show(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $response = $this->getJson("/api/myProfile");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                'id',
                'name',
                'email',
                'birth_place',
                'birth_date',
                'phone',
                'address',
                'photo',
                'component'
                    ]
        ]);
    }
    public function test_check_profile_full(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
            'name' => fake()->name(),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'phone' => fake()->unique()->numerify('############'),
            'address' => fake()->text(20),
            'component' => fake()->text(10),
        ]); 
        Sanctum::actingAs($user);
        $response = $this->getJson("/api/checkProfile");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_check_profile_empty(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->getJson("/api/checkProfile");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_user_update(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/myProfile", [
            'name' => 'Kholid',
            'birth_place' => 'Kudus',
            'birth_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'phone' => '08774837301',
            'address' => 'Kedungsari, Sendang, Kudus',
            'component' => 'Mahasiswa',
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                'id',
                'name',
                'email',
                'birth_place',
                'birth_date',
                'phone',
                'address',
                'photo',
                'component'
                    ]
        ]);
    }
    public function test_user_update_validation_error(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/myProfile", [
            'name' => 'Kholid',
            'birth_place' => 'Kudus',
            'birth_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'phone' => '08774837301',
            'component' => 'Mahasiswa',
        ]);
        $response->assertStatus(404)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_user_password_update(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/password", [
            'old_password'        =>'password',
            'new_password'         =>'newpassword',
            'confirm_password' =>'newpassword'
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                'id',
                'name',
                'email',
                'birth_place',
                'birth_date',
                'phone',
                'address',
                'photo',
                'component'
                    ]
        ]);
    }
    public function test_user_password_update_validation_error(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/password", [
            'old_password'        =>'password',
            'new_password'         =>'newpassword',
            'confirm_password' =>'newpassword2'
        ]);
        $response->assertStatus(422)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_user_wrong_old_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/password", [
            'old_password'        =>'password2',
            'new_password'         =>'newpassword',
            'confirm_password' =>'newpassword'
        ]);
        $response->assertStatus(422)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_upload_photo_profile()
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]);
        Sanctum::actingAs($user);
        Storage::fake('local');
        $response = $this->postJson('/api/photo', [
            'photo'=>UploadedFile::fake()->image('photo.jpg')
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                'id',
                'name',
                'email',
                'birth_place',
                'birth_date',
                'phone',
                'address',
                'photo',
                'component'
                    ]
        ]);
    }
}
