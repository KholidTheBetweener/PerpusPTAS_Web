<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Categories;
use Laravel\Sanctum\Sanctum;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
    }
    public function test_book_index(): void
    {
        $k=Categories::factory(6)->create();
        $books = Book::factory(2)->create();
        $response = $this->getJson('/api/books');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                        'id',
                        'book_code',
                        'book_title',
                        'author',
                        'category',
                        'publisher',
                        'stock',
                        'book_cover',
                        'book_desc',
                        'barcode',
                    ]
            ]
        ]);
    }
    public function test_book_show(): void
    {
        $k=Categories::factory(6)->create();
        $books = Book::factory()->create();
        $response = $this->getJson("/api/books/{$books->id}");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                        'id',
                        'book_code',
                        'book_title',
                        'author',
                        'category',
                        'publisher',
                        'stock',
                        'book_cover',
                        'book_desc',
                        'barcode',
                    ]
        ]);
    }
    public function test_book_show_fail(): void
    {
        $k=Categories::factory(6)->create();
        $books = Book::factory(10)->create();
        $number = rand(11,20);
        $response = $this->getJson("/api/books/{$number}");
        $response->assertStatus(404)->assertJsonStructure([
            'success',
            'message',
        ]);
    }
    public function test_book_cannot_rent(): void
    {
        $k=Categories::factory(6)->create();
        $books = Book::factory()->create(['stock' => 0]);
        $response = $this->getJson("/api/books/{$books->id}");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                        'id',
                        'book_code',
                        'book_title',
                        'author',
                        'category',
                        'publisher',
                        'stock',
                        'book_cover',
                        'book_desc',
                        'barcode',
                    ]
        ]);
    }
}
