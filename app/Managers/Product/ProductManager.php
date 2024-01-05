<?php

namespace App\Managers\Product;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\UpdateProductDTO;
use App\Models\Product\Product;
use App\Services\Product\ProductService;
use App\DTO\Product\CreateProductDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @file
 * Contains ProductManager.php
 */
class ProductManager
{
    protected ProductService $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param CreateProductDTO $createProductDTO
     * @return Product
     * @throws Throwable
     */
    public function create(CreateProductDTO $createProductDTO): Product
    {
        DB::beginTransaction();
        try {
            $product = $this->productService->create($createProductDTO);
            DB::commit();

            return $product;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateProductDTO $updateProductDTO): Model
    {
        DB::beginTransaction();
        try {
            $product = $this->productService->update($updateProductDTO);
            DB::commit();

            return $product;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Product
     */
    public function find(int $id, array $relations = []): Product
    {
        return $this->productService->find($id, $relations);
    }


    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return $this->productService->getAll($paginationFilterDTO);
    }
}
