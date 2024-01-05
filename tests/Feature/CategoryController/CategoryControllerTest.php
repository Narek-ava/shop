<?php

namespace Tests\Feature\CategoryController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_category()
    {
        $data = [
            'slug' => 'slug-20',
            'parentId' => 1,
            'nameTranslations' => [
                'en' => 'name test en',
                'hy' => 'name test hy'
            ],
        ];
        $response = $this->post('api/categories', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'slug' => $data['slug']
        ]);
        $this->assertDatabaseHas('category_translations', [
            'value' => [
                $data['nameTranslations']['en'],
                $data['nameTranslations']['hy']
            ]
        ]);
    }

    public function test_get_category_tree()
    {
        $response = $this->get('api/categories/getCategoryTree');

        $response->assertStatus(200);
    }
}
