<?php

namespace Tests\Unit\UserController;

use App\Http\Controllers\API\V1\UserController;
use App\Http\Requests\API\V1\User\CreateRequest;
use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserControllerUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_create(): void
    {
        $request = $this->getMockBuilder(CreateRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('getName')
            ->willReturn('John Doe 19');

        $request->expects($this->once())
            ->method('getEmail')
            ->willReturn('john19@example.com');

        $request->expects($this->once())
            ->method('getPasswordValue')
            ->willReturn('password');

        $controller = new UserController();

        $response = $controller->createAction($request);

        $this->assertEquals('ok', $response->getData());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function test_get_auth_user(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        Passport::actingAs($user, ['api']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/users/auth-user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
                'id',
                'name',
                'email',
        ]);
    }
}
