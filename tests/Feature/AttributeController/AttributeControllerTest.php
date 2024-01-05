<?php

namespace Tests\Feature\AttributeController;

use App\Models\Attribute\Attribute;
use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AttributeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_attribute_create()
    {
        $data = [
            'isFilterable' => true,
            'position' => 1,
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
        ];

        $response = $this->post('api/attributes', $data);

        $this->assertEquals(201, $response->status());
        $this->assertDatabaseHas('attributes', [
            'is_filterable' => $data['isFilterable'],
            'position' => $data['position'],
        ]);
        $this->assertDatabaseHas('attribute_translations', [
            'value' => [
                $data['nameTranslations']['en'],
                $data['nameTranslations']['hy']
            ]
        ]);
    }

//    public function test_get_attribute_by_id()
//    {
//        $attributeCount = Attribute::query()->count();
//        $attributeId = rand(1, $attributeCount);
//
//        $response = $this->get('/api/attributes/' . $attributeId);
//
//        $response->assertOk(); //todo method not created in this branch
//    }

    public function test_autocomplete_attribute_search()
    {
        $searchText = 'na';

        $response = $this->get('/api/attributes/search?searchText=' . $searchText);

        $response->assertOk();
    }
}
