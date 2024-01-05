<?php

namespace App\Managers\FavoritesProduct;

use App\DTO\FavoritesProduct\FavoritesProductDTO;
use App\Http\Requests\API\V1\FavoritesProduct\FavoritesProductDeleteRequest;
use App\Models\Favorites\FavoritesProduct;
use App\Services\FavoritesProduct\FavoritesProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class FavoritesProductManager
{
    protected FavoritesProductService $favoritesProductService;

    public function __construct(FavoritesProductService $favoritesProductService)
    {
        $this->favoritesProductService = $favoritesProductService;
    }

    /**
     * @throws Throwable
     */
    public function create(FavoritesProductDTO $favoritesProductDTO): JsonResponse
    {
        DB::beginTransaction();
        try {
            $favoritesProduct = $this->favoritesProductService->create($favoritesProductDTO);
            DB::commit();

            return $favoritesProduct;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id): JsonResponse
    {
        return $this->favoritesProductService->delete($id);
    }

    public function get(): LengthAwarePaginator
    {
        return $this->favoritesProductService->get();
    }
}
