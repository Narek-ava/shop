<?php

namespace Tests\Feature\PromoCodeController;

use App\Models\User\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PromoCodeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_create_promo_code()
    {
        $data = [
            'code' => 'zinger12345',
            'discountAmount' => '1000',
            'discountPercent' => '15',
            'maxUses' => '23',
            'expiredAt' => '2023-11-11 01:02:03',
            'productVariantId' => [1, 2]
        ];

        $response = $this->post('/api/promo-codes', $data);

        $response->assertOk();
        $this->assertDatabaseHas('promo_codes', [
            'code' => $data['code'],
            'discount_amount' => $data['discountAmount'],
            'discount_percent' => $data['discountPercent'],
            'max_uses' => $data['maxUses'],
            'expired_at' => $data['expiredAt'],
        ]);
    }
}
