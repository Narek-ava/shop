<?php

namespace Tests\Feature\ProductVariantController;

use App\Models\Product\Variant\ProductVariant;
use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProductVariantControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_product_variant()
    {
        $data = [
            'productId' => '1',
            'sku' => 'sku-5',
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
            'price' => '3000'
        ];

        $response = $this->post('/api/product-variants', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('product_variants', [
            'sku' => $data['sku']
        ]);
    }

    public function test_attach_option_to_product_variant()
    {
        $data = [
            'productVariantId' => '1',
            'optionId' => '1'
        ];

        $response = $this->post('/api/product-variants/attach-option', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('product_variant_options', [
            'product_variant_id' => $data['productVariantId'],
            'option_id' => $data['optionId']
        ]);
    }

    public function test_update_product_variant()
    {
        $data = [
            'productId' => '1',
            'sku' => 'sku-6',
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
            'price' => '3400'
        ];

        $productVariantsCount = ProductVariant::query()->count();
        $productVariantId = rand(1, $productVariantsCount);

        $response = $this->patch('/api/product-variants/' . $productVariantId, $data);

        $response->assertOk();
        $this->assertDatabaseHas('product_variants', [
            'sku' => $data['sku']
        ]);
    }
}
