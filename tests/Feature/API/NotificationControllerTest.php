<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Categories;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewBookNotification;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_notification(): void
    {
        //Notification::fake();
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $book = Book::factory()->create();
        $user->notify(new NewBookNotification($book));
        $book2 = Book::factory()->create();
        $user->notify(new NewBookNotification($book2));
        $response = $this->getJson('/api/notifications');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                    'id',
                    'data',
                    'read_at',
                    'created_at'
                    ]
            ]
        ]);
    }
    public function test_notification_read(): void
    {
        $user = User::factory()->create([
            'email' => 'test@dev.com',
            'password' => bcrypt('password'),
        ]); 
        Sanctum::actingAs($user);
        $k=Categories::factory(6)->create();
        $book = Book::factory()->create();
        $user->notify(new NewBookNotification($book));
        $notification = $user->notifications;
        $response = $this->postJson("/api/notifications/{$notification[0]->id}");
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  =>[
                    'id',
                    'data',
                    'read_at',
                    'created_at'
                    ]
        ]);
    }
}
