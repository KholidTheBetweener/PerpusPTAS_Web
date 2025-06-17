<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rent;
use App\Models\Book;
use App\Models\Admin;
use App\Models\User;
use App\Models\Categories;
use Carbon\Carbon;

class RentControllerTest extends TestCase
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
        
        Categories::factory(6)->create();
        Book::factory(10)->create([
            'stock' => 10,
        ]);
        User::factory(10)->create();
    }
    public function test_rent_all(): void
    {
        Rent::factory(10)->create();
        $response = $this->get(route('rent.record'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.all');
        $response->assertViewHas('rows');
    }
    public function test_rent_search_form(): void
    {
        $response = $this->get(route('rent.search'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.search');
    }
    public function test_rent_search_result(): void
    {
        Rent::factory(10)->create();
        $response = $this->get(route('rent.track'), ['name' => 'a']);
        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.all');
        $response->assertViewHas('rows');
    }
    public function test_rent_index(): void
    {
        Rent::factory(10)->create();
        Rent::factory(10)->create([
            'date_rent' => Carbon::now(),
            'date_due' => Carbon::now()->addWeeks(2),
            'status' => true,
        ]);
        Rent::factory(10)->create([
            'date_rent' => Carbon::now()->subWeeks(3),
            'date_due' => Carbon::now()->subWeeks(),
            'status' => true,
        ]);
        Rent::factory(10)->create([
            'date_rent' => Carbon::now()->subWeeks(1),
            'date_due' => Carbon::now()->addWeeks(1),
            'date_return' => Carbon::now(),
            'status' => false,
        ]);
        $response = $this->get(route('rent.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.index');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent.index', ['type' => 'pending']));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.index');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent.index', ['type' => 'renting']));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.index');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent.index', ['type' => 'overdue']));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.index');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent.index', ['type' => 'finish']));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.index');
        $response->assertViewHas('rows');
    }
    public function test_rent_show(): void
    {
        $rent = Rent::factory()->create();

        $response = $this->get(route('rent.show', $rent));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.show');
        $response->assertViewHas('pinjam');
    }
    public function test_rent_approve_only(): void
    {
        $rent = Rent::factory()->create();
        $response = $this->post(route('rent.approve', $rent));

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Peminjaman telah disetujui');
    }
    public function test_rent_approve_and_delete_other_book_request(): void
    {
        $book = Book::factory()->create([
            'stock' => 1,
        ]);
        Rent::factory(10)->create(['books_id' => $book->id]);
        $rent = Rent::factory()->create(['books_id' => $book->id]);
        $response = $this->post(route('rent.approve', $rent));

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Peminjaman telah disetujui dan pengajuan peminjaman untuk buku yang sama ditolak');
    }
    public function test_rent_return(): void
    {
        $rent = Rent::factory()->create([
            'date_rent' => Carbon::now(),
            'date_due' => Carbon::now()->addWeeks(2),
            'status' => true,
        ]);
        $response = $this->post(route('rent.return', $rent));

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Buku Telah dikembalikan');
    }
    public function test_rent_warning(): void
    {
        $rent = Rent::factory()->create([
            'date_rent' => Carbon::now(),
            'date_due' => Carbon::now()->addWeeks(2),
            'status' => true,
        ]);
        $response = $this->get(route('rent.alert', $rent));
        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Peringatan telat pengembalian telah dikirim');
        $rent2 = Rent::factory()->create([
            'date_rent' => Carbon::now()->subWeeks(3),
            'date_due' => Carbon::now()->subWeeks(),
            'status' => true,
        ]);
        $response = $this->get(route('rent.warning', $rent2));
        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Peringatan telat pengembalian telah dikirim');
    }
    public function test_rent_create_form(): void
    {
        $response = $this->get(route('rent.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.create');
    }
    public function test_rent_store(): void
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $data = [
            'name' => $user->name,
            'book_title' => $book->book_title,
        ];
        //dd($data);
        $response = $this->post(route('rent.store'), $data);

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Pinjam has been created successfully.');

        $this->assertDatabaseHas('rents', ['users_id' => $user->id]);
    }
    public function test_rent_edit_form(): void
    {
        $rent = Rent::factory()->create([
            'date_rent' => Carbon::now()->subWeeks(1),
            'date_due' => Carbon::now()->addWeeks(1),
            'date_return' => Carbon::now(),
            'status' => false,
        ]);

        $response = $this->get(route('rent.edit', $rent));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rent.edit');
        $response->assertViewHas('rent', $rent);
    }
    public function test_rent_update(): void
    {
        $rent = Rent::factory()->create([
            'date_rent' => Carbon::now()->subWeeks(1),
            'date_due' => Carbon::now()->addWeeks(1),
            'date_return' => Carbon::now(),
            'status' => false,
        ]);

        $data = [
            'books_id' => 2,
            'users_id' => 3,
            'date_request' => Carbon::now()->subweeks(),
            'date_rent' => Carbon::now(),
            'status' => true,
        ];
        //$this->withoutExceptionHandling();
        $response = $this->put(route('rent.update', $rent), $data);

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Pinjam Has Been updated successfully');

        $this->assertDatabaseHas('rents', [
            'id' => $rent->id,
            'books_id' => 2,
            'users_id' => 3,
        ]);
    }
    public function test_rent_delete(): void
    {
        $user = Rent::factory()->create();

        $response = $this->delete(route('rent.destroy', $user));

        $response->assertRedirect(route('rent.index'));
        $response->assertSessionHas('success', 'Pinjam has been deleted successfully');

        $this->assertDatabaseMissing('rents', ['id' => $user->id]);
    }
}
