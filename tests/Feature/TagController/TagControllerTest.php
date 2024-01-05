<?php

namespace Tests\Feature\TagController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_tag()
    {
        $data = [
            'productVariantId' => 1,
            'tags' => 'test tag'
        ];

        $response = $this->post('/api/tags', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('product_variant_tags', [
            'product_variant_id' => $data['productVariantId'],
            'tags' => $data['tags']
        ]);
    }
}
