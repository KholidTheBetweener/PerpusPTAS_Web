<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Categories;
use App\Models\User;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_categories_index(): void
    {
        $k=Categories::factory(6)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'  => [
                '*' =>[
                        'id',
                        'name'
                    ]
            ]
        ]);
    }
}
