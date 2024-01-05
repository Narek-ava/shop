<?php

namespace Tests\Feature\ReviewController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_product_variant_review()
    {
        $data = [
            'rating' => 3,
            'reviewTitle' => 'title',
            'review' => 'test',
            'productVariantId' => 1
        ];

        $response = $this->post('api/reviews', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('product_variant_reviews', [
            'rating' => $data['rating'],
            'review_title' => $data['reviewTitle'],
            'review' => $data['review'],
            'product_variant_id' => $data['productVariantId']
        ]);
    }
}
