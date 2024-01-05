<?php

namespace Tests\Feature\FavoritesProductController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FavoritesProductControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_favorites_products()
    {
        $data = [
            'productVariantId' => 1,
            'userId' => 1
        ];

        $response = $this->post('api/favorites/create', $data);

        $response->assertOk();
        $this->assertDatabaseHas('favorites_products', [
            'product_variants_id' => $data['productVariantId'],
            'user_id' => auth()->id(),
        ]);
    }

    public function test_delete_favorites_products()
    {
        $data = [
            'id' => 1
        ];

        $response = $this->post('api/favorites/delete', $data);

        $response->assertOk();
    }

    public function test_get_favorite_products()
    {
        $response = $this->get('api/favorites');

        $response->assertOk();
    }
}
