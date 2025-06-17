<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Categories;
use App\Models\Book;
use App\Models\Rent;
use App\Notifications\NewBookNotification;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create([
            'name' => 'test user',
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        $this->actingAs($user);
    }
    public function test_index(): void
    {
        Categories::factory(6)->create();
        Book::factory(10)->create();
        Book::factory(10)->create(['stock' => 0]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('books');

        $response = $this->get(route('home', ['type' => 'tersedia']));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('books');

        $response = $this->get(route('home', ['type' => 'habis']));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('books');
    }
    public function test_book_show_cannot_rent(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        $response = $this->get(route('detail', $book->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.detail');
        $response->assertViewHas('book');
    }
    public function test_book_show_can_rent(): void
    {
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        Storage::fake('local');
        $data = [
            'name' => 'Updated Name',
            'birth_place' => $city = fake()->city(),
            'birth_date' => $date = fake()->date($format = 'Y-m-d', $max = 'now'),
            'phone' => $phone = fake()->unique()->numerify('############'),
            'address' => $address  = fake()->text(20),
            'component' => $component = fake()->text(10),
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];
        $response = $this->post(route('userupdate'), $data);
        $response = $this->get(route('detail', $book->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.detail');
        $response->assertViewHas('book');

    }
    public function test_search(): void
    {
        Categories::factory(6)->create();
        Book::factory(10)->create();

        $response = $this->get(route('search', ['name' => 'a']));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('books');
    }
    public function test_profile(): void
    {
        $response = $this->get(route('userprofile'));

        $response->assertStatus(200);
        $response->assertViewIs('user.profile');
        $response->assertViewHas('user');
    }
    public function test_update(): void
    {
        Storage::fake('local');
        $data = [
            'name' => 'Updated Name',
            'birth_place' => $city = fake()->city(),
            'birth_date' => $date = fake()->date($format = 'Y-m-d', $max = 'now'),
            'phone' => $phone = fake()->unique()->numerify('############'),
            'address' => $address  = fake()->text(20),
            'component' => $component = fake()->text(10),
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ];
        $response = $this->post(route('userupdate'), $data);

        $response->assertRedirect(route('userprofile'));
        $response->assertSessionHas('success', 'User Has Been updated successfully');
        $this->assertDatabaseHas('users', [
            'name' => 'Updated Name',
            'birth_place' => $city,
            'birth_date' => $date,
            'phone' => $phone,
            'address' => $address,
            'component' => $component,
        ]);
    }
    public function test_emailpassword(): void
    {
        $data = [
            'email' => 'updated.email@example.com',
            'password' => 'qwerty12345',
        ];

        $response = $this->post(route('emailpassword'), $data);

        $response->assertRedirect(route('userprofile'));
        $response->assertSessionHas('success', 'User Has Been updated successfully');

        $this->assertDatabaseHas('users', [
            'email' => 'updated.email@example.com',
        ]);
    }
    public function test_notifications(): void
    {
        $user = \Auth::user();
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        $user->notify(new NewBookNotification($book));
        $book2 = Book::factory()->create();
        $user->notify(new NewBookNotification($book2));
        
        $response = $this->get(route('notifications'));

        $response->assertStatus(200);
        $response->assertViewIs('user.notification');
        $response->assertViewHas('notifications');
    }
    public function test_marknotify(): void
    {
        $user = \Auth::user();
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        Notification::send($user, new NewBookNotification($book));
        $notification = $user->notifications;
        $response = $this->post(route('marknotify', $notification[0]->id));
        $response->assertSessionHas('success','Notifikasi Sudah Terbaca');
        $response->assertRedirect(route('notifications'));
    }
    public function test_marknotifyall(): void
    {
        $user = \Auth::user();
        $this->actingAs($user);
        Categories::factory(6)->create();
        $book = Book::factory()->create();
        Notification::send($user, new NewBookNotification($book));
        $book2 = Book::factory()->create();
        Notification::send($user, new NewBookNotification($book2));
        //dd($notification = $user->unreadNotifications);
        $response = $this->get(route('marknotifyall'));
        $response->assertSessionHas('success','Notifikasi Sudah Terbaca');
        $response->assertRedirect(route('notifications'));
    }
    public function test_rent(): void
    {        
        $user = \Auth::user();
        Categories::factory(6)->create();
        Book::factory(10)->create([]);
        Rent::factory(10)->create([
            'users_id' => $user->id,
        ]);
        Rent::factory(10)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now(),
            'date_due' => Carbon::now()->addWeeks(2),
            'status' => true,
        ]);
        Rent::factory(10)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now()->subWeeks(3),
            'date_due' => Carbon::now()->subWeeks(),
            'status' => true,
        ]);
        Rent::factory(10)->create([
            'users_id' => $user->id,
            'date_rent' => Carbon::now()->subWeeks(1),
            'date_due' => Carbon::now()->addWeeks(1),
            'date_return' => Carbon::now(),
            'status' => false,
        ]);
        $response = $this->get(route('rent'));

        $response->assertStatus(200);
        $response->assertViewIs('user.rent');
        $response->assertViewHas('rows');
        
        $response = $this->get(route('rent', ['type' => 'pending']));

        $response->assertStatus(200);
        $response->assertViewIs('user.rent');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent', ['type' => 'renting']));

        $response->assertStatus(200);
        $response->assertViewIs('user.rent');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent', ['type' => 'overdue']));

        $response->assertStatus(200);
        $response->assertViewIs('user.rent');
        $response->assertViewHas('rows');

        $response = $this->get(route('rent', ['type' => 'finish']));

        $response->assertStatus(200);
        $response->assertViewIs('user.rent');
        $response->assertViewHas('rows');
    }
    public function test_rentinfo(): void
    {
        $user = \Auth::user();
        Categories::factory(6)->create();
        Book::factory(10)->create();
        $rent = Rent::factory()->create([
            'users_id' => $user->id
        ]);
        $response = $this->get(route('rentinfo', $rent));
        $response->assertStatus(200);
        $response->assertViewIs('user.rentinfo');
        $response->assertViewHas('pinjam');
    }
    public function test_store(): void
    {
        $book = Book::factory()->create();
        $data = [
            'id' => $book->id,
        ];
        //dd($data);
        $response = $this->post(route('requestrent', $data));

        $response->assertRedirect(route('rent'));
        $response->assertSessionHas('success', 'Pinjam has been created successfully.');

        $this->assertDatabaseHas('rents', ['books_id' => $data['id']]);    
    }
    public function test_dashboard(): void
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, guard: 'admin');
        Categories::factory(6)->create();
        Book::factory(10)->create();

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin');
        $response->assertViewHas('admin');
    }
    public function test_marknotification(): void
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, guard: 'admin');
        $user = User::factory()->create();
        event(new Registered($user));
        $notification = $admin->notifications;
        $response = $this->post(route('admin.markNotification', $notification[0]->id));
        $response->assertSessionHas('success','Notifikasi Sudah Terbaca');
        $response->assertRedirect(route('admin.dashboard'));
    }
    public function test_markall(): void
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, guard: 'admin');
        $user = User::factory()->create();
        event(new Registered($user));
        $user = User::factory()->create();
        event(new Registered($user));
        $notification = $admin->notifications;
        $response = $this->post(route('admin.markAll'));
        $response->assertSessionHas('success','Notifikasi Sudah Terbaca');
        $response->assertRedirect(route('admin.dashboard'));
    }
}
