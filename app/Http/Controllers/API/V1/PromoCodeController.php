<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PromoCode\PromoCodeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PromoCode\PromoCodeRequest;
use Illuminate\Http\JsonResponse;
use App\Managers\PromoCode\PromoCodeManager;
use Throwable;

class PromoCodeController extends Controller
{
    protected PromoCodeManager $promoCodeManager;

    /**
     * @param PromoCodeManager $promoCodeManager
     */
    public function __construct(PromoCodeManager $promoCodeManager)
    {
        $this->promoCodeManager = $promoCodeManager;
    }

    /**
     * @param PromoCodeRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function createPromoCode(PromoCodeRequest $request): JsonResponse
    {
        $promoCodeDTO = new PromoCodeDTO(
            $request->getCode(),
            $request->getDiscountAmount(),
            $request->getDiscountPercent(),
            $request->getMaxUses(),
            $request->getExpiredAt(),
            $request->getProductVariantId(),
        );
       return $this->promoCodeManager->create($promoCodeDTO);
    }
}
