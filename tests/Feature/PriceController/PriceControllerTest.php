<?php

namespace Tests\Feature\PriceController;

use Tests\TestCase;

class PriceControllerTest extends TestCase
{
    public function test_create_price_type()
    {
        $data = [
            'priority' => 3,
            'descriptionTranslation' => [
                'en' => 'deposit test en',
                'hy' => 'deposit test hy'
            ],
            'nameTranslations' => [
                'en' => 'text test en',
                'hy' => 'text test hy'
            ],
        ];

        $response = $this->post('api/price-type', $data);

        $response->assertOk();
        $this->assertDatabaseHas('price_types', [
            'priority' => $data['priority'],
        ]);
        $this->assertDatabaseHas('price_type_translations', [
            'value' => [
                $data['nameTranslations']['en'],
                $data['nameTranslations']['hy'],
                $data['descriptionTranslation']['en'],
                $data['descriptionTranslation']['hy'],
            ]
        ]);
    }

    public function test_get_price_type()
    {
        $response = $this->get('api/price-type/get-type');

        $response->assertOk();
    }

    public function test_create_product_variant_price()
    {
        $data = [
            'variant_id' => 1,
            'price_type_id' => 6,
            'amount' => 2000,
            'currency' => 'AMD'
        ];

        $response = $this->post('api/price-type/variant-price', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('variant_prices', [
            'variant_id' => $data['variant_id'],
            'price_type_id' => $data['price_type_id'],
            'amount' => $data['amount'],
            'currency' => $data['currency']
        ]);
    }
}
