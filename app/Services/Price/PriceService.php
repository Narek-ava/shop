<?php

namespace App\Services\Price;

use App\DTO\Price\CreatePriceTypeDTO;

use App\DTO\Price\CreateVariantPriceDTO;
use App\DTO\Price\UpdatePriceTypeDTO;
use App\DTO\Price\UpdateVariantPriceDTO;
use App\Models\Price\PriceType;
use App\Models\Price\PriceTypeTranslation;
use App\Models\Price\VariantPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PriceService
{
    /**
     * @param CreatePriceTypeDTO $priceDTO
     * @return PriceType
     */
    public function createPriceType(CreatePriceTypeDTO $priceDTO): PriceType
    {
      $priceType =new PriceType();
      $priceType->priority = $priceDTO->priority;
      $priceType->save();

       foreach ($priceDTO->priceTypeTranslationsDTO as $priceTranslationDto) {
           $priceTranslation = new PriceTypeTranslation();
           $priceTranslation->price_type_id = $priceType->id;
           $priceTranslation->locale = $priceTranslationDto->locale;
           $priceTranslation->field = $priceTranslationDto->field;
           $priceTranslation->value = $priceTranslationDto->text;
           $priceTranslation->save();
       }

      return $priceType;
   }

    /**
     * @param $locale
     * @return array|Collection
     */
    public function getPriceType($locale): Collection|array
    {
       $query = PriceTypeTranslation::all();
       if ($locale){
          $query = $query->where('locale',$locale);
       }
       return $query;
    }

    /**
     * @param CreateVariantPriceDTO $variantPriceDTO
     * @return VariantPrice
     */
    public function createVariantPrice(CreateVariantPriceDTO $variantPriceDTO): VariantPrice
    {
        $variantPrice = new VariantPrice();
        $variantPrice->setVariantId($variantPriceDTO->variantId);
        $variantPrice->setPriceTypeId($variantPriceDTO->priceTypeId);
        $variantPrice->setAmount($variantPriceDTO->amount);
        $variantPrice->setCurrency($variantPriceDTO->currency);
        $variantPrice->save();
        return $variantPrice;
    }

    /**
     * @param UpdatePriceTypeDTO $updatePriceTypeDTO
     * @return Model
     */
    public function update(UpdatePriceTypeDTO $updatePriceTypeDTO): Model
    {

        $updatePriceType = PriceType::query()
            ->where('id', $updatePriceTypeDTO->priceTypeId)->first();
        $updatePriceType->priority = $updatePriceTypeDTO->priority;
        $updatePriceType->save();

        foreach ($updatePriceTypeDTO->priceTypeTranslationsDTO as $translations) {
            PriceTypeTranslation::query()
                ->updateOrCreate([
                    'price_type_id' => $updatePriceTypeDTO->priceTypeId,
                    'field' => $translations->field,
                    'locale' => $translations->locale->toString()
                ], [
                    'value' => $translations->text
                ]);
        }
        return $updatePriceType;
    }

    /**
     * @param UpdateVariantPriceDTO $updateVariantPriceDTO
     * @return Model
     */
    public function updateVariantPrice(UpdateVariantPriceDTO $updateVariantPriceDTO): Model
    {
        $updateVariantPrice = VariantPrice::query()
            ->where('id', $updateVariantPriceDTO->priceVariantId)->first();
        $updateVariantPrice->amount = $updateVariantPriceDTO->amount;
        $updateVariantPrice->save();
        return $updateVariantPrice;
    }
}
