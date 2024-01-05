<?php

namespace App\Managers\Option;

use App\Models\Attribute\Option\Option;
use App\Models\Attribute\Option\OptionTranslation;
use App\Services\Option\OptionService;
use App\DTO\Option\CreateOptionDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @file
 * Contains OptionManager.php
 */
class OptionManager
{
    protected OptionService $optionService;

    /**
     * @param OptionService $optionService
     */
    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
    }

    /**
     * @param CreateOptionDTO $createOptionDTO
     * @return Option
     * @throws Throwable
     */
    public function create(CreateOptionDTO $createOptionDTO): Option
    {
        DB::beginTransaction();
        try {
            $option = $this->optionService->create($createOptionDTO);
            DB::commit();

            return $option;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param string $searchText
     * @param array $relations
     * @param int $limit
     * @return Collection
     */
    public function search(int | null $attributeId, string $searchText, array $relations = [], int $limit = 10): Collection
    {
        return $this->optionService->search($attributeId,$searchText, $relations, $limit);
    }

    /**
     * @param int $id
     * @return void
     * @throws Throwable
     */
    public function delete(int $id): void
    {
        DB::beginTransaction();
        try {
            $this->optionService->delete($id);
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();
    }
    /**
     * @param int $id
     * @param array $relations
     * @return Option|Collection
     * @throws ModelNotFoundException
     */
    public function find(int $id, array $relations = []): Option|Collection
    {
        return $this->optionService->find($id, $relations);
    }

}
