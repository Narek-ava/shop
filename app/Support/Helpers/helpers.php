<?php

use App\Models\Cart\Cart;
use App\Services\Cart\CartServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (!function_exists('getCarts')) {
    /**
     * @return Collection|array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    function getCarts(): Collection|array
    {
        $cartService = new CartServices();

        $token = getOrCreateCartTokenFromSession();

        $authId = auth()->id();
        $carts = $cartService->getByUserIdOrToken($authId, $token);

        DB::beginTransaction();
        try {
            if ($carts->count() > 1) {
                $cartService->mergeCartsProduct($carts);
                $carts = $cartService->removeUnused($carts);
            }

            foreach ($carts as $cart) {
                if ($cart->token !== $token) {
                    $cart = $cartService->updateToken($cart, $token);
                }

                if ($authId && !$cart->user_id) {
                    $cartService->updateUserId($cart, $authId);
                }
            }

            if ($carts->isEmpty()) {
                $carts = Collection::make([$cartService->create($token, $authId)]);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        DB::commit();
        return $carts;
    }
}

if (!function_exists('getOrCreateCartTokenFromSession')) {

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function getOrCreateCartTokenFromSession():string
    {
        $token = session()->get('token');

        if (!$token) {
            $token = Str::random(30);
            session()->put('token', $token);
        }

        return $token;
    }
}
