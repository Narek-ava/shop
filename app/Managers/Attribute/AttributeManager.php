<?php

namespace App\Managers\Attribute;

use App\DTO\Attribute\UpdateAttributeDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeTranslation;
use App\Models\Attribute\Option\Option;
use App\Models\Attribute\Option\OptionTranslation;
use App\Services\Attribute\AttributeService;
use App\DTO\Attribute\CreateAttributeDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @file
 * Contains AttributeManager.php
 */
class AttributeManager
{
    protected AttributeService $attributeService;

    /**
     * @param AttributeService $attributeService
     */
    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * @param CreateAttributeDTO $createAttributeDTO
     * @return Attribute
     * @throws Throwable
     */
    public function create(CreateAttributeDTO $createAttributeDTO): Attribute
    {
        DB::beginTransaction();
        try {
            $attribute = $this->attributeService->create($createAttributeDTO);
            DB::commit();

            return $attribute;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param string $searchText
     * @param int $limit
     * @param array $relations
     * @return Builder[]|Collection
     */
    public function search(string $searchText,  array $relations = [], int $limit = 10): Collection|array
    {
        return $this->attributeService->search($searchText, $relations, $limit);
    }

    public function getById($attributeId)
    {
          return Attribute::query()->where('id', $attributeId)->first();

    }

    public function update(UpdateAttributeDTO $updateAttributeDTO)
    {
        DB::beginTransaction();
        try {
            $category = $this->attributeService->update($updateAttributeDTO);
            DB::commit();

            return $category;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return $this->attributeService->getAll($paginationFilterDTO);
    }
}
