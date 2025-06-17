<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Admin;
use App\Models\User;
use App\Models\Rent;
use App\Models\Categories;
use Excel;
use App\Imports\BookImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class BookControllerTest extends TestCase
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
    public function test_book_search(): void
    {
        Categories::factory(6)->create();
        Book::factory(10)->create();

        $response = $this->get(route('book.search', ['q' => 'a']));
        //dd($response);
        $response->assertStatus(200)->assertJsonStructure([
                '*' =>[
                        'id',
                        'book_title',
                    ]
        ]);
    }
    public function test_book_index(): void
    {
        Categories::factory(6)->create();
        Book::factory(10)->create();

        $response = $this->get(route('book.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.book.index');
        $response->assertViewHas('books');
    }
    public function test_book_show(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();

        $response = $this->get(route('book.show', $book->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.book.show');
        $response->assertViewHas('book');
    }
    public function test_book_cover(): void
    {
        Categories::factory(6)->create();
        Storage::fake('local');
        $data = Book::factory()->create( [
            'book_code' => '123646557',
            'book_title' => 'Test Book',
            'author' => 'test author',
            'category' => rand(1, 6),
            'publisher' => 'test publisher',
            'stock' => rand(1, 10),
            'book_desc' => 'description of this text can be long but I will do the best',
        ]);
        $response = $this->post(route('book.cover', $data), [
            'book_cover'=>UploadedFile::fake()->image('photo.jpg')
        ]);

        $response->assertRedirect(route('book.show', $data->id));
        $response->assertSessionHas('success', 'Book cover has been uploaded.');

        $this->assertDatabaseHas('books', ['book_title' => 'Test Book']);
    }
    public function test_book_barcode(): void
    {
        Categories::factory(6)->create();
        $data = Book::factory()->create( [
            'book_code' => '123646557',
            'book_title' => 'Test Book',
            'author' => 'test author',
            'category' => rand(1, 6),
            'publisher' => 'test publisher',
            'stock' => rand(1, 10),
            'book_desc' => 'description of this text can be long but I will do the best',
        ]);
        $response = $this->post(route('book.barcode', $data), [
            'barcode'=>fake()->unique()->numerify('######################'),
        ]);

        $response->assertRedirect(route('book.show', $data->id));
        $response->assertSessionHas('success', 'Buku Has Been updated successfully');

        $this->assertDatabaseHas('books', ['book_title' => 'Test Book']);
    }
    public function test_book_create_form(): void
    {
        $response = $this->get(route('book.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.book.create');
    }
    public function test_book_store(): void
    {
        Categories::factory(6)->create();
        Storage::fake('local');
        $data = [
            'book_code' => '123646557',
            'book_title' => 'Test Book',
            'author' => 'test author',
            'category' => rand(1, 6),
            'publisher' => 'test publisher',
            'stock' => rand(1, 10),
            'book_cover' => UploadedFile::fake()->image('photo.jpg'),
            'book_desc' => 'description of this text can be long but I will do the best',
        ];
        $response = $this->post(route('book.store'), $data);

        $response->assertRedirect(route('book.index'));
        $response->assertSessionHas('success', 'Buku has been created successfully.');

        $this->assertDatabaseHas('books', ['book_title' => 'Test Book']);
    }
    public function test_book_import(): void
    {
        Categories::factory(6)->create();
        User::factory(6)->create();
        //$file = UploadedFile::fake()->create('bookdata.xlsx');
        Excel::fake();
        Storage::fake();
        //$content = array(rand(1,6), fake()->unique()->text(10), fake()->text(10), fake()->name(), fake()->name(), fake()->text(20), rand(1,6));
        $file = UploadedFile::fake()->create(
            base_path('test/Files/bookdata.xlsx'), 'bookdata.xlsx'
        );
        //$this->withoutExceptionHandling();
        $response = $this->post(route('book.import'), ['file' => $file]);
        $response->assertRedirect(route('book.index'));
        $response->assertSessionHas('success', 'Excel file imported successfully!');
        Excel::assertImported('bookdata.xlsx');
    }
    public function test_book_edit_form(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();

        $response = $this->get(route('book.edit', $book));

        $response->assertStatus(200);
        $response->assertViewIs('admin.book.edit');
        $response->assertViewHas('book', $book);
    }
    public function test_book_update(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        Storage::fake('local');
        $photo = UploadedFile::fake()->image('photo.jpg');
        $data = [
            'book_code' => '123646557',
            'book_title' => 'test buku',
            'author' => 'test author',
            'category' => 6,
            'publisher' => 'test publisher',
            'stock' => 3,
            'book_cover' => $photo,
            'book_desc' => 'description of this text can be long but I will do the best',
            'barcode' => 'a23646557l',
        ];

        $response = $this->put(route('book.update', $book), $data);

        $response->assertRedirect(route('book.index'));
        $response->assertSessionHas('success', 'Buku Has Been updated successfully');

        $this->assertDatabaseHas('books', [
            'book_code' => '123646557',
            'book_title' => 'test buku',
            'author' => 'test author',
            'category' => 6,
            'publisher' => 'test publisher',
            'stock' => 3,
            'book_desc' => 'description of this text can be long but I will do the best',
        ]);
    }
    public function test_book_delete(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();

        $response = $this->delete(route('book.destroy', $book));

        $response->assertRedirect(route('book.index'));
        $response->assertSessionHas('success', 'Buku has been deleted successfully');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
    public function test_cannot_delete_rented_book(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $rent = Rent::factory()->create([
            'books_id' => $book->id,
            'users_id' => $user->id,
        ]);
        $response = $this->delete(route('book.destroy', $book));
        $count = $rent->count();
        $response->assertRedirect(route('book.index'));
        $response->assertSessionHas('success', 'Ada '. $count .' Catatan Peminjaman untuk buku ini dan catatan perlu dihapus dulu sebelum buku bisa dihapus');

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}
