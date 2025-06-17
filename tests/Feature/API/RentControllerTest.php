<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Categories;
use App\Models\Rent;
use App\Models\Book;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Carbon\Carbon;

class RentControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_rent_index(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory(3)->create([
            'users_id' => $user->id
        ]);
        $response = $this->getJson('/api/rent');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
            ]
        ]);
    }
    public function test_rent_index_pending(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory(3)->create([
            'users_id' => $user->id
        ]);
        $response = $this->getJson('/api/rent?type=pending');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
            ]
        ]);
    }
    public function test_rent_index_renting(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        //Carbon::setTestNow(Carbon::now());
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory(3)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now(),
            'date_due' => Carbon::now()->addWeeks(2),
            'status' => true,
        ]);
        $response = $this->getJson('/api/rent?type=renting');       
        //dd($response);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
            ]
        ]);
    }
    public function test_rent_index_overdue(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory(3)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now()->subWeeks(3),
            'date_due' => Carbon::now()->subWeeks(),
            'status' => true,
        ]);
        $response = $this->getJson('/api/rent?type=overdue');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
            ]
        ]);
    }
    public function test_rent_index_finish(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory(3)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now()->subWeeks(1),
            'date_due' => Carbon::now()->addWeeks(1),
            'date_return' => Carbon::now(),
            'status' => false,
        ]);
        $response = $this->getJson('/api/rent?type=finish');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
            ]
        ]);
    }
    public function test_rent_show(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory()->create([
            'users_id' => $user->id
        ]);
        $response = $this->getJson("/api/rent/{$rent->id}");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
        ]);
    }
    public function test_rent_not_found(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $rent = Rent::factory()->create([
            'users_id' => $user->id
        ]);
        $random = rand(2,10);
        $response = $this->getJson("/api/rent/{$random}");
        $response->assertStatus(404)->assertJsonStructure([
            'success',
            'message'
        ]);
    }
    public function test_rent_store(): void
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
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $response = $this->postJson("/api/rent", [
            'books_id' => rand(1, 10),
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                    'id',
                    'books_id',
                    'users_id',
                    'date_request',
                    'date_rent',
                    'date_due',
                    'date_return',
                    'status',
                    'book',
                    ]
        ]);
    }
    public function test_rent_validation_error(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $response = $this->postJson("/api/rent");
        
        $response->assertStatus(404)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_rent_empty_stock_fail(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create(['stock' => 0]);
        $response = $this->postJson("/api/rent", [
            'books_id' => rand(1, 10),
        ]);
        $response->assertStatus(428)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_rent_user_detail_not_complete(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $response = $this->postJson("/api/rent", [
            'books_id' => rand(1, 10),
        ]);
        $response->assertStatus(422)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    public function test_rent_delete(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $books = Book::factory()->create();
        $rent = Rent::factory()->create([
            'users_id' => $user->id,
            'books_id' => $books->id,
        ]);
        $response = $this->json('delete', "/api/rent/$rent->id");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);

        $this->assertDatabaseMissing('rents', ['id' => $rent->id]);
    }
}
