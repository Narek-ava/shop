<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\CreateProductDTO;
use App\DTO\Product\ProductTranslationDTO;
use App\DTO\Product\UpdateProductDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Requests\API\V1\Product\CreateRequest;
use App\Http\Requests\API\V1\Product\GetByIdRequest;
use App\Http\Requests\API\V1\Product\UpdateRequest;
use App\Http\Requests\Media\DeleteMediaByIdRequest;
use App\Http\Resources\V1\Product\ProductResource;
use App\Managers\Product\ProductManager;
use App\Models\Product\Product;
use App\Services\Media\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class ProductController extends Controller
{
    private ProductManager $productManager;
    public  MediaService $mediaService;

    /**
     * @param ProductManager $productManager
     * @param MediaService $mediaService
     */
    public function __construct(
        ProductManager $productManager,
        MediaService $mediaService
    )
    {
        $this->mediaService = $mediaService;
        $this->productManager = $productManager;
    }

    /**
     * @param CreateRequest $request
     * @return ProductResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): ProductResource
    {
        $productTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $productTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::NAME_FIELD,
                $text,
            );
        }

        foreach ($request->getDescriptionTranslations() as $locale => $text) {
            $productTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::DESCRIPTION_FIELD,
                $text,
            );
        }

        foreach ($request->getShortDescriptionTranslations() as $locale => $text) {
            $productTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::SHORT_DESCRIPTION_FIELD,
                $text,
            );
        }

        $productDto = new CreateProductDTO(
            $request->getCategoryId(),
            $request->getPosition(),
            $request->getPublished(),
            $productTranslationsDTO,
            $request->getBrandId(),
        );

        $product = $this->productManager->create($productDto)->load(
            [
                 'category',
                 'brand',
                 'nameTranslations',
             ]
        );
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }

        $product->load(['nameTranslations','images']);
        return new ProductResource($product);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request): ProductResource
    {
        $updateProductTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $updateProductTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::NAME_FIELD,
                $text,
                $request->getId(),
            );
        }

        foreach ($request->getDescriptionTranslations() as $locale => $text) {
            $updateProductTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::DESCRIPTION_FIELD,
                $text,
                $request->getId(),
            );
        }

        foreach ($request->getShortDescriptionTranslations() as $locale => $text) {
            $updateProductTranslationsDTO[] = new ProductTranslationDTO(
                LocalesEnum::from($locale),
                Product::SHORT_DESCRIPTION_FIELD,
                $text,
                $request->getId(),
            );
        }

        $updateProductDto = new UpdateProductDTO(

            $request->getPosition(),
            $request->getPublished(),
            $request->getBrandId(),
            $request->getId(),
            $updateProductTranslationsDTO,
            $request->getImages()
        );

        $updateProduct = $this->productManager->update($updateProductDto)->load('category', 'brand');
        return new ProductResource($updateProduct);
    }

    public function findAction(GetByIdRequest $request): ProductResource
    {
        $product = $this->productManager->find($request->getId(), [
            'nameTranslations',
            'descriptionTranslations',
            'shortDescriptionTranslations',
            'brand',
            'category',
            'variants',
            'variants.options',
        ]);

        return new ProductResource($product);
    }

    /**
     * @param DeleteMediaByIdRequest $request
     * @return JsonResponse
     */
    public function deleteImage(DeleteMediaByIdRequest $request): JsonResponse
    {
        return $this->mediaService->deleteMediaById($request->getId());
    }

    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $getAllProductsDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            ['nameTranslations','images']
        );

        $products = $this->productManager->getAll($getAllProductsDTO);

        return ProductResource::collection($products);
    }

}
