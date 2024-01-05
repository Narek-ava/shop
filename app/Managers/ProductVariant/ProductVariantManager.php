<?php

namespace App\Managers\ProductVariant;

use App\DTO\ProductVariant\CheckAvailableStatusDTO;
use App\DTO\ProductVariant\CheckPublishedStatusDTO;
use App\DTO\ProductVariant\ProductVariantAttachOptionDTO;
use App\DTO\ProductVariant\CreateProductVariantQuantityDTO;
use App\DTO\ProductVariant\ProductVariantDetachOptionDTO;
use App\DTO\ProductVariant\UpdateProductVariantDTO;
use App\Http\Requests\API\V1\ProductVariant\CheckPublishedStatusRequest;
use App\Models\Product\Variant\ProductVariant;
use App\Models\Product\Variant\ProductVariantQuantity;
use App\Services\ProductVariant\ProductVariantQuantityService;
use App\Services\ProductVariant\ProductVariantService;
use App\DTO\ProductVariant\CreateProductVariantDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @file
 * Contains ProductVariantManager.php
 */
class ProductVariantManager
{
    protected ProductVariantService $productVariantService;
    protected ProductVariantQuantityService $productVariantQuantityService;

    /**
     * @param ProductVariantService $productVariantService
     * @param ProductVariantQuantityService $productVariantQuantityService
     */
    public function __construct(
        ProductVariantService $productVariantService,
        ProductVariantQuantityService $productVariantQuantityService,
    )
    {
        $this->productVariantService = $productVariantService;
        $this->productVariantQuantityService = $productVariantQuantityService;
    }

    /**
     * @param CreateProductVariantDTO $createProductVariantDTO
     * @return ProductVariant
     * @throws Throwable
     */
    public function create(CreateProductVariantDTO $createProductVariantDTO): ProductVariant
    {
        DB::beginTransaction();
        try {
            $productVariant = $this->productVariantService->create($createProductVariantDTO);
            DB::commit();

            return $productVariant;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param UpdateProductVariantDTO $updateProductVariantDTO
     * @throws Throwable
     */
    public function update(UpdateProductVariantDTO $updateProductVariantDTO)
    {
        DB::beginTransaction();
        try {

            $updateProductVariant = $this->productVariantService->update($updateProductVariantDTO);
            DB::commit();

            return $updateProductVariant;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param ProductVariantAttachOptionDTO $productVariantAttachOptionDTO
     * @return void
     */
    public function attachOption(ProductVariantAttachOptionDTO $productVariantAttachOptionDTO): void
    {
        $this->productVariantService->attachOption($productVariantAttachOptionDTO);
    }

    /**
     * @param ProductVariantDetachOptionDTO $productVariantDetachOptionDTO
     * @return void
     */
    public function detachOption(ProductVariantDetachOptionDTO $productVariantDetachOptionDTO): void
    {
        $this->productVariantService->detachOption($productVariantDetachOptionDTO);
    }

    /**
     * @param CreateProductVariantQuantityDTO $productVariantQuantityDTO
     * @return ProductVariant
     */
    public function addQuantity(CreateProductVariantQuantityDTO $productVariantQuantityDTO): ProductVariant
    {
       return $this->productVariantQuantityService->create($productVariantQuantityDTO);
    }

    /**
     * @param $productVariantQuantity
     * @return Model|Builder|null
     */
    public function getById($productVariantQuantity): Model|Builder|null
    {
       return $this->productVariantQuantityService->getById($productVariantQuantity);
    }

    /**
     * @param string $searchText
     * @param int $limit
     * @param array $relations
     * @return Collection|array
     */
    public function search(string $searchText, int $limit = 10, array $relations = []): Collection|array
    {
        return $this->productVariantService->search($searchText, $limit, $relations);
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Collection|ProductVariant
     * @throws ModelNotFoundException
     */
    public function find(int $id = 10, array $relations = []): Collection|ProductVariant
    {
        $productVariants = $this->productVariantService->find($id, $relations)->load(['images','quantity','tags','options']);
        $productVariants->options->load('attribute');

        return $productVariants;
    }

    /**
     * @param CheckAvailableStatusDTO $availableStatusDTO
     * @return JsonResponse
     */
    public function checkAvailableStatus(CheckAvailableStatusDTO $availableStatusDTO): JsonResponse
    {
        return $this->productVariantService->checkAvailableStatus($availableStatusDTO);
    }

    public function getPopular(array $relations = [], int | null $limit = 10): Collection|array
    {
        return $this->productVariantService->getPopular($relations, $limit);
    }

    public function checkPublishedStatus(CheckPublishedStatusDTO $checkPublishedStatusDTO)
    {
        return $this->productVariantService->checkPublishedStatus($checkPublishedStatusDTO);

    }
}
