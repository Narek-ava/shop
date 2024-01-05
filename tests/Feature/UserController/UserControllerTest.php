<?php

namespace Tests\Feature\UserController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testUserCreate()
    {
        $userData = [
            'name' => 'John Doe 13',
            'email' => 'johndoe12@example.com',
            'password' => 'password19922',
        ];

        $response = $this->post('api/users/', $userData);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('users',['email'=>'johndoe13@example.com']);
    }

    public function testGetAuthUser()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->get('/api/users/auth-user');

        $response->assertStatus(200);
    }
}
