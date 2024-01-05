<?php

namespace Tests\Feature\CartController;

use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_add_product_to_cart() //todo check
    {
        $data = [
            'productVariantId' => 3,
            'count' => 4
        ];

        $response = $this->post('api/carts/product_variants', $data);

        $response->assertStatus(201);
    }

//    public function test_get_cart_items() //todo route not exists
//    {
//        $response = $this->get('api/carts');
//
//        $response->assertOk();
//    }
}
