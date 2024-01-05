<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Price\CreatePriceTypeDTO;
use App\DTO\Price\CreateVariantPriceDTO;
use App\DTO\Price\PriceTypeTranslationsDTO;
use App\DTO\Price\UpdatePriceTypeDTO;
use App\DTO\Price\UpdateTypeTranslationsDTO;
use App\DTO\Price\UpdateVariantPriceDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PriceType\CreateRequest;
use App\Http\Requests\API\V1\PriceType\CreateVariantPriceRequest;
use App\Http\Requests\API\V1\PriceType\GetPriceTypeRequest;
use App\Http\Requests\API\V1\PriceType\UpdateRequest;
use App\Http\Requests\API\V1\PriceType\UpdateVariantPriceRequest;
use App\Http\Resources\V1\Price\PriceTypeResources;
use App\Http\Resources\V1\Price\UpdateVariantPrices;
use App\Http\Resources\V1\Price\VariantPrices;
use App\Managers\Price\PriceManager;
use App\Models\Price\PriceType;
use Throwable;

class PriceController extends Controller
{
    protected PriceManager $priceManager;

    public function __construct(PriceManager $priceManager)
    {
        $this->priceManager = $priceManager;
    }

    /**
     * @param CreateRequest $request
     * @return PriceTypeResources
     * @throws Throwable
     */
    public function createPriceType(CreateRequest $request): PriceTypeResources
    {
        $priceTypeTranslationsDTO = [];
        foreach ($request->getTypeTranslations() as $locale => $text) {
            $priceTypeTranslationsDTO[] = new PriceTypeTranslationsDTO(
                LocalesEnum::from($locale),
                PriceType::NAME_FIELD,
                $text,
            );
        }

        foreach ($request->getDescriptionTranslation() as $locale => $text) {
            $priceTypeTranslationsDTO[] = new PriceTypeTranslationsDTO(
                LocalesEnum::from($locale),
                PriceType::DESCRIPTION_FIELD,
                $text,
            );
        }
        $priceTypeDTO = new CreatePriceTypeDTO(
            $request->getPriority(),
            $priceTypeTranslationsDTO
        );

        $priceType = $this->priceManager->createPriceType($priceTypeDTO);
        $priceType->load(['nameTranslations']);

        return new PriceTypeResources($priceType);
    }

    /**
     * @param GetPriceTypeRequest $request
     * @return array
     */
    public function getPriceType(GetPriceTypeRequest $request): array
    {
        $priceTypeData = [];
        $priceTypes = $this->priceManager->getPriceType($request->locale);
        foreach ($priceTypes as $priceType){
            $priceTypeData[] = new PriceTypeResources($priceType);
        }
        return  $priceTypeData;
    }

    /**
     * @param CreateVariantPriceRequest $request
     * @return VariantPrices
     * @throws Throwable
     */
    public function createVariantPrice(CreateVariantPriceRequest $request): VariantPrices
    {
        $variantPriceDTO = new CreateVariantPriceDTO(
            $request->getVariantId(),
            $request->getPriceTypeId(),
            $request->getAmount(),
            $request->getCurrency()
        );
        $variantPrice = $this->priceManager->createVariantPrice($variantPriceDTO);

        return new VariantPrices($variantPrice);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request): PriceTypeResources
    {
        $priceTypeTranslationsDTO = [];
        foreach ($request->getTypeTranslations() as $locale => $text) {
            $priceTypeTranslationsDTO[] = new UpdateTypeTranslationsDTO(
                LocalesEnum::from($locale),
                PriceType::NAME_FIELD,
                $text,
            );
        }

        foreach ($request->getDescriptionTranslation() as $locale => $text) {
            $priceTypeTranslationsDTO[] = new UpdateTypeTranslationsDTO(
                LocalesEnum::from($locale),
                PriceType::DESCRIPTION_FIELD,
                $text,
            );
        }

        $updatePriceTypeDTO = new UpdatePriceTypeDTO(
            $request->getPriority(),
            $request->getId(),
            $priceTypeTranslationsDTO
        );

        $priceType = $this->priceManager->update($updatePriceTypeDTO);
        $priceType->load(['nameTranslations']);

        return new PriceTypeResources($priceType);
    }

    /**
     * @throws Throwable
     */
    public function updateVariantPrice(UpdateVariantPriceRequest $request): UpdateVariantPrices
    {

        $updateVariantPrice = new UpdateVariantPriceDTO(
            $request->getAmount(),
            $request->getId()
        );
        $variantPrice = $this->priceManager->updateVariantPrice($updateVariantPrice);

        return new UpdateVariantPrices($variantPrice);
    }
}
