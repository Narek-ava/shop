<?php

namespace Tests\Feature\OptionController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OptionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_option()
    {
        $data = [
            'attributeId' => '1',
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
        ];

        $response = $this->post('/api/options', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('options', [
            'attribute_id' => $data['attributeId']
        ]);
    }

    public function test_autocomplete_option_search()
    {
        $searchText = 'hy';

        $response = $this->get('/api/options/search?searchText=' . $searchText);

        $response->assertOk();
    }
}
