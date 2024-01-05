<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Product\ProductTranslationDTO;
use App\DTO\ProductVariant\CheckAvailableStatusDTO;
use App\DTO\ProductVariant\CheckPublishedStatusDTO;
use App\DTO\ProductVariant\CreateProductVariantDTO;
use App\DTO\ProductVariant\ProductVariantAttachOptionDTO;
use App\DTO\ProductVariant\CreateProductVariantQuantityDTO;
use App\DTO\ProductVariant\ProductVariantDetachOptionDTO;
use App\DTO\ProductVariant\ProductVariantTranslationDTO;
use App\DTO\ProductVariant\UpdateProductVariantDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V\ProductVariant\DetachOptionRequest;
use App\Http\Requests\API\V1\ProductVariant\AttachOptionRequest;
use App\Http\Requests\API\V1\ProductVariant\CheckAvailableStatusRequest;
use App\Http\Requests\API\V1\ProductVariant\CheckPublishedStatusRequest;
use App\Http\Requests\API\V1\ProductVariant\CreateRequest;
use App\Http\Requests\API\V1\ProductVariant\FindRequest;
use App\Http\Requests\API\V1\ProductVariant\GetPopularRequest;
use App\Http\Requests\API\V1\ProductVariant\GetQuantityByVariantIdrequest;
use App\Http\Requests\API\V1\ProductVariant\QuantityRequest;
use App\Http\Requests\API\V1\ProductVariant\SearchRequest;
use App\Http\Requests\API\V1\ProductVariant\UpdateRequest;
use App\Http\Requests\Media\DeleteMediaByIdRequest;
use App\Http\Resources\V1\ProductVariant\ProductVariantQuantityResource;
use App\Http\Resources\V1\ProductVariant\ProductVariantResource;
use App\Managers\ProductVariant\ProductVariantManager;
use App\Models\Product\Product;
use App\Models\Product\Variant\ProductVariant;
use App\Services\Media\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class ProductVariantController extends Controller
{
    private ProductVariantManager $productVariantManager;
    public MediaService $mediaService;

    /**
     * @param ProductVariantManager $productVariantManager
     */
    public function __construct(
        ProductVariantManager $productVariantManager,
        MediaService $mediaService
    )
    {
        $this->mediaService = $mediaService;
        $this->productVariantManager = $productVariantManager;
    }

    /**
     * @param CreateRequest $request
     * @return ProductVariantResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): ProductVariantResource
    {
        $productVariantTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $productVariantTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::NAME_FIELD,
                $text,
            );
        }

        $productVariantDto = new CreateProductVariantDTO(
            $request->getProductId(),
            $request->getSku(),
            $request->getPosition(),
            $request->getPublished(),
            $request->getPrice(),
            $productVariantTranslationsDTO,
            $request->getImages(),
        );

        $productVariant = $this->productVariantManager->create($productVariantDto);
        $productVariant->load(['nameTranslations','images']);
        return new ProductVariantResource($productVariant);
    }

    /**
     * @throws Throwable
     */
    public function updateAction(UpdateRequest $request): ProductVariantResource
    {

        $updateProductVariantTranslationsDTO = [];

        if ($request->getNameTranslations() !== null) {

            foreach ($request->getNameTranslations() as $locale => $text) {
                $updateProductVariantTranslationsDTO[] = new ProductVariantTranslationDTO(
                    LocalesEnum::from($locale),
                    Product::NAME_FIELD,
                    $text,
                    $request->getId(),
                );
            }
        }

        $updateProductVariantDto = new UpdateProductVariantDTO(
            $request->getId(),
            $request->getSku(),
            $request->getPublished(),
            $request->getPosition(),
            $updateProductVariantTranslationsDTO,
            $request->getImages(),
        );
        $updatedProductVariant = $this->productVariantManager->update($updateProductVariantDto);
        $updatedProductVariant->load(['nameTranslations','images']);

        return new ProductVariantResource($updatedProductVariant);
    }

    /**
     * @param SearchRequest $request
     * @return AnonymousResourceCollection
     */
    public function searchAction(SearchRequest $request): AnonymousResourceCollection
    {
        return ProductVariantResource::collection(
            $this->productVariantManager->search($request->getSearchText(), $request->getLimit() ?: 10)
        );
    }


    /**
     * @param FindRequest $request
     * @return ProductVariantResource
     */
    public function findAction(FindRequest $request): ProductVariantResource
    {
        return new ProductVariantResource(
            $this->productVariantManager->find($request->getId(), ['nameTranslations','options','quantity'])
        );
    }

    /**
     * @param AttachOptionRequest $request
     * @return JsonResponse
     */
    public function attachOptionAction(AttachOptionRequest $request): JsonResponse
    {
        $productVariantAttachOptionDTO = new ProductVariantAttachOptionDTO(
            $request->getProductVariantId(),
            $request->getOptionId(),
        );

        $this->productVariantManager->attachOption($productVariantAttachOptionDTO);

        return response()->json('ok', 201);
    }

    /**
     * @param DetachOptionRequest $request
     * @return JsonResponse
     */
    public function detachOptionAction(DetachOptionRequest $request): JsonResponse
    {
        $productVariantAttachOptionDTO = new ProductVariantDetachOptionDTO(
            $request->getProductVariantId(),
            $request->getOptionId(),
        );

        $this->productVariantManager->detachOption($productVariantAttachOptionDTO);

        return response()->json('ok', 201);
    }

    /**
     * @param QuantityRequest $request
     * @return ProductVariantQuantityResource
     */
    public function addQuantityAction(QuantityRequest $request): ProductVariantQuantityResource
    {
        $productVariantQuantityDTO = new CreateProductVariantQuantityDTO($request->getQuantity(), $request->route('id'));

        $productVariant = $this->productVariantManager->addQuantity($productVariantQuantityDTO)->load('quantity');

        return new ProductVariantQuantityResource($productVariant);


    }

//    public function getPrice() //todo remove if no need
//    {
//        return ProductVariant::query()
//            ->select('id', 'product_id', 'sku', 'quantity', 'published', 'position')
//            ->with(['price' => function ($query) {
//                $query->select('id', 'amount', 'type', 'product_variant_id', 'description');
//            }])
//            ->get();
//    }

    /**
     * @param GetQuantityByVariantIdrequest $request
     * @return ProductVariantQuantityResource
     */
    public function getQuantityByIdAction(GetQuantityByVariantIdrequest $request): ProductVariantQuantityResource
    {
        $productVariant = $this->productVariantManager->getById($request->variantId);


        return new ProductVariantQuantityResource($productVariant);

    }


    public function deleteImage(DeleteMediaByIdRequest $request): JsonResponse
    {
       return $this->mediaService->deleteMediaById($request->getId());
    }

    /**
     * @param CheckAvailableStatusRequest $request
     * @return JsonResponse
     */
    public function checkAvailableStatus(CheckAvailableStatusRequest $request): JsonResponse
    {
       $checkAvailableStatusDTO = new CheckAvailableStatusDTO(
           $request->getVariantId(),
           $request->getAvailable()
       );
        return $this->productVariantManager->checkAvailableStatus($checkAvailableStatusDTO);
    }

    public function getPopular(GetPopularRequest $request)
    {
        $variants = $this->productVariantManager->getPopular(['nameTranslations'],$request->getLimit());
        $variants->load('images');
        return ProductVariantResource::collection($variants);
    }

    public function checkPublishedStatus(CheckPublishedStatusRequest $request)
    {
        $checkPublishedStatusDTO = new CheckPublishedStatusDTO(
            $request->getVariantId(),
            $request->getPublished()
        );
        return $this->productVariantManager->checkPublishedStatus($checkPublishedStatusDTO);
    }
}
