<?php

namespace App\Managers\Category;

use App\DTO\Category\UpdateCategoryDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Models\Category\Category;
use App\Services\Category\CategoryService;
use App\DTO\Category\CreateCategoryDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @file
 * Contains CategoryManager.php
 */
class CategoryManager
{
    protected CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param CreateCategoryDTO $createCategoryDTO
     * @return Category
     * @throws Throwable
     */
    public function create(CreateCategoryDTO $createCategoryDTO): Category
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryService->create($createCategoryDTO);
            DB::commit();

            return $category;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param array $categoryIds
     * @return Collection|array
     */
    public function getTreeWithSubcategories(array $categoryIds): Collection|array
    {
        return $this->categoryService->getTreeWithSubcategories($categoryIds);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateCategoryDTO $updateCategoryDTO): Model|Builder
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryService->update($updateCategoryDTO);
            DB::commit();

            return $category;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * @param string $searchText
     * @param array $relations
     * @param int $limit
     * @return Collection|array
     */
    public function search(string $searchText, array $relations = [], int $limit = 10): Collection|array
    {
        return $this->categoryService->search($searchText,$relations, $limit);
    }

    /**
     * @param int $limit
     * @param array $relations
     * @return Collection|array
     */
    public function getPopular(int $limit = 10, array $relations = []): Collection|array
    {
        return $this->categoryService->getPopular($limit, $relations);
    }

    /**
     * @param $id
     * @param array $relations
     * @return Builder|Collection|Category
     * @throws ModelNotFoundException
     */
    public function find($id, array $relations = []): Collection|Builder|Category
    {
        return $this->categoryService->find($id, $relations);
    }


    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return $this->categoryService->getAll($paginationFilterDTO);
    }
}
