<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\FavoritesProduct\FavoritesProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FavoritesProduct\FavoritesProductDeleteRequest;
use App\Http\Requests\API\V1\FavoritesProduct\FavoritesProductRequest;
use App\Managers\FavoritesProduct\FavoritesProductManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;


class FavoritesProductController extends Controller
{
    protected FavoritesProductManager $favoritesProductManager;

    public function __construct(FavoritesProductManager $favoritesProductManager)
    {
        $this->favoritesProductManager = $favoritesProductManager;
    }

    /**
     * @throws \Throwable
     */
    public function createAction(FavoritesProductRequest $request): JsonResponse
    {
        $favoritesProductDTO = new FavoritesProductDTO(
            $request->getProductVariantId(),
            $request->getUserId(), //todo check need in request
        );
        return $this->favoritesProductManager->create($favoritesProductDTO);
    }

    public function deleteAction(FavoritesProductDeleteRequest $request): JsonResponse
    {
        return $this->favoritesProductManager->delete($request->getId());
    }

    public function getProductAction(): LengthAwarePaginator
    {
        return $this->favoritesProductManager->get();
    }
}
