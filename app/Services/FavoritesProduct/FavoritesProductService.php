<?php

namespace App\Services\FavoritesProduct;

use App\DTO\FavoritesProduct\FavoritesProductDTO;
use App\Models\Favorites\FavoritesProduct;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class FavoritesProductService
{
    public function create(FavoritesProductDTO $favoritesProductDTO): JsonResponse
    {
        $userId = auth()->id();
        $favoritesProduct = new FavoritesProduct();
        $favoritesProduct->product_variants_id = $favoritesProductDTO->productVariantId;
        $favoritesProduct->user_id = $userId;
        $favoritesProduct->save();

        return response()->json('ok', '200');
    }
    public function delete(int $id): JsonResponse
    {
        $productDelete = FavoritesProduct::query()->where('product_variants_id', $id);
        $productDelete->delete();

        return response()->json('ok',);
    }

    public function get(): LengthAwarePaginator
    {
        $userId = auth()->id();

        return FavoritesProduct::query()->where('user_id', $userId)->paginate(20);
    }

}
