<?php

namespace Tests\Feature\ProductController;

use App\Models\Product\Product;
use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_product()
    {
        $data = [
            'categoryId' => '3',
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
            'descriptionTranslations' => [
                'en' => 'description en',
                'hy' => 'description hy'
            ],
            'shortDescriptionTranslations' => [
                'en' => 'shortDescription en',
                'hy' => 'shortDescription hy'
            ],
        ];

        $response = $this->post('/api/products', $data);

        $this->assertEquals(201, $response->status());
        $this->assertDatabaseHas('products', [
            'category_id' => $data['categoryId']
        ]);
        $this->assertDatabaseHas('product_translations', [
            'value' => [
                $data['nameTranslations']['en'],
                $data['nameTranslations']['hy'],
                $data['descriptionTranslations']['en'],
                $data['descriptionTranslations']['hy'],
                $data['shortDescriptionTranslations']['en'],
                $data['shortDescriptionTranslations']['hy'],
            ]
        ]);
    }

    public function test_get_product_by_id()
    {
        $productCount = Product::query()->count();
        $productId = rand(1, $productCount);

        $response = $this->get('/api/products/' . $productId);

        $response->assertOk();
    }
}
