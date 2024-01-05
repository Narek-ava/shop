<?php

namespace App\Managers\Price;

use App\DTO\Price\CreatePriceTypeDTO;
use App\DTO\Price\CreateVariantPriceDTO;
use App\DTO\Price\UpdatePriceTypeDTO;
use App\DTO\Price\UpdateVariantPriceDTO;
use App\Models\Price\PriceType;
use App\Models\Price\VariantPrice;
use App\Services\Price\PriceService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class PriceManager
{
    protected PriceService $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * @param CreatePriceTypeDTO $priceTypeDTO
     * @return PriceType
     * @throws Throwable
     */
    public function createPriceType(CreatePriceTypeDTO $priceTypeDTO): PriceType
    {
        DB::beginTransaction();
        try {
            $price = $this->priceService->createPriceType($priceTypeDTO);
            DB::commit();

            return $price;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $locale
     * @return array|Collection
     */
    public function getPriceType($locale): Collection|array
    {
        return $this->priceService->getPriceType($locale);
    }

    /**
     * @param CreateVariantPriceDTO $variantPriceDTO
     * @return VariantPrice
     * @throws Throwable
     */
    public function createVariantPrice(CreateVariantPriceDTO $variantPriceDTO): VariantPrice
    {
        DB::beginTransaction();
        try {
            $variantPrice = $this->priceService->createVariantPrice($variantPriceDTO);
            DB::commit();
            return $variantPrice;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatePriceTypeDTO $updatePriceTypeDTO): Model
    {
        DB::beginTransaction();
        try {
            $variantPrice = $this->priceService->update($updatePriceTypeDTO);
            DB::commit();
            return $variantPrice;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function updateVariantPrice(UpdateVariantPriceDTO $updateVariantPriceDTO): Model
    {
        DB::beginTransaction();
        try {
            $variantPrice = $this->priceService->updateVariantPrice($updateVariantPriceDTO);
            DB::commit();
            return $variantPrice;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
