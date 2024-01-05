<?php

namespace App\Managers\Brand;

use App\DTO\Brand\UpdateBrandDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Models\Brand\Brand;
use App\Services\Brand\BrandService;
use App\DTO\Brand\CreateBrandDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * @file
 * Contains BrandManager.php
 */
class BrandManager
{
    protected BrandService $brandService;

    /**
     * @param BrandService $brandService
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * @param CreateBrandDTO $createBrandDTO
     * @return Brand
     * @throws Throwable
     */
    public function create(CreateBrandDTO $createBrandDTO): Brand
    {
        return $this->brandService->create($createBrandDTO);
    }

    /**
     * @param $searchText
     * @return Collection|array
     */
    public function search($searchText): Collection|array
    {
        return $this->brandService->search($searchText);
    }

    public function updateAction(UpdateBrandDTO $updateBrandDTO): Model
    {
        return $this->brandService->updateAction($updateBrandDTO);
    }

    /**
     * @param $id
     * @param array $relations
     * @return Collection|Brand
     * @throws ModelNotFoundException
     */
    public function find($id, array $relations = []): Collection|Brand
    {
        return $this->brandService->find($id, $relations);
    }

    /**
     * @param int $limit
     * @param array $relations
     * @return Collection|array
     */
    public function getPopular(int $limit = 10, array $relations = []): Collection|array
    {
        return $this->brandService->getPopular($limit, $relations);
    }


    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return $this->brandService->getAll($paginationFilterDTO);
    }
}
