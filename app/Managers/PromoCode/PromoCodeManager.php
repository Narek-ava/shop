<?php

namespace App\Managers\PromoCode;

use App\DTO\PromoCode\PromoCodeDTO;
use App\Services\PromoCode\PromoCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class PromoCodeManager
{
    protected PromoCodeService $promoCodeService;

    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * @throws Throwable
     */
    public function create(PromoCodeDTO $promoCodeDTO): JsonResponse
    {
        DB::beginTransaction();
        try {
            $promoCode = $this->promoCodeService->create($promoCodeDTO);
            DB::commit();

            return $promoCode;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
