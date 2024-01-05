<?php

namespace Tests\Feature\BrandController;

use App\Models\Brand\Brand;
use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_brand()
    {
        $data = [
            'name' => 'brand name',
            'slug' => 'brand-2',
            'position' => '10'
        ];

        $response = $this->post('/api/brands', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('brands', [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'position' => $data['position']
        ]);
    }

    public function test_autocomplete_brand_search()
    {
        $searchText = 'Iphone';

        $response = $this->get('/api/brands/search?searchText=' . $searchText);

        $response->assertOk();
    }

    public function test_update_brand()
    {
        $data = [
            'name' => 'brand name 1',
            'slug' => 'brand-2',
            'position' => '11'
        ];

        $brandsCount = Brand::query()->count();
        $brandId = rand(1, $brandsCount);

        $response = $this->patch('/api/brands/' . $brandId, $data);

        $response->assertOk();
        $this->assertDatabaseHas('brands', [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'position' => $data['position']
        ]);
    }
}
