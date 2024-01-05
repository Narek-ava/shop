<?php

namespace App\Services\PromoCode;

use App\DTO\PromoCode\PromoCodeDTO;
use App\Models\PromoCode\ProductVariantsPromoCode;
use App\Models\PromoCode\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class PromoCodeService
{

    /**
     * @param PromoCodeDTO $promoCodeDTO
     * @return JsonResponse
     */
    public function create(PromoCodeDTO $promoCodeDTO): JsonResponse
    {

        $promoCode = new PromoCode();
        $promoCode->code = $promoCodeDTO->code;
        $promoCode->discount_amount = $promoCodeDTO->discountAmount;
        $promoCode->discount_percent = $promoCodeDTO->discountPercent;
        $promoCode->max_uses = $promoCodeDTO->max_uses;
        $promoCode->starting_at = Carbon::now();
        $promoCode->expired_at = $promoCodeDTO->expiredAt;
        $promoCode->save();

        if (!empty($promoCodeDTO->productVariantId)) {
            foreach ($promoCodeDTO->productVariantId as $productVariantId) {
                $productPromo = new ProductVariantsPromoCode();
                $productPromo->product_variant_id = $productVariantId;
                $productPromo->promo_code_id = $promoCode->id;
                $productPromo->save();
            }
        }

        return response()->json('ok', '200');
    }

}
