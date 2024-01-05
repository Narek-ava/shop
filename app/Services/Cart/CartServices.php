<?php

namespace App\Services\Cart;


use App\Models\Cart\Cart;
use App\Models\CartProductVariant\CartsProductVariants;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\MockObject\MatchBuilderNotFoundException;

class CartServices
{
    public function create(string $token, ?int $userId): Cart
    {
        $cart = new Cart;
        $cart->setUserId($userId);
        $cart->setToken($token);
        $cart->save();

        return $cart;
    }

    /**
     * @param int|null $userId
     * @param string|null $token
     * @return Collection
     * @throws Exception
     */
    public function getByUserIdOrToken(?int $userId, ?string $token): Collection
    {
        if (!$userId && !$token) {
            throw new Exception('At last one argument must be not null');
        }

        $result = Cart::query()->orderByDesc('id');

        if ($userId) {
            $this->filterUserId($result, $userId);
            if ($token) {
                $result->orWhere('token', $token);
            }
        } else {
            $this->filterToken($result, $token);
        }

        return $result->get();
    }

    /**
     * @param Cart $cart
     * @return bool
     */
    public function canRemoveCart(Cart $cart): bool
    {
        return $cart->productVariants()->count() === 0;
    }

    /**
     *
     * @param Collection $carts
     * @return Collection
     */
    public function removeUnused(Collection $carts): Collection
    {
        foreach ($carts as $key => $cart) {
            if ($carts->count() > 1) {
                if ($this->canRemoveCart($cart)) {
                    Log::info('Delete Cart: ' . $cart->id);
                    $cart->delete();
                    $carts->forget($key);
                }
            }
        }

        return $carts;
    }

    /**
     * @param Collection $carts
     * @return void
     */
    public function mergeCartsProduct(Collection $carts): void
    {
        $lastCart = $carts->first();
        $cartIds = $carts->pluck('id')->toArray();

       CartsProductVariants::query()->whereIn('cart_id', $cartIds)->update(['cart_id' => $lastCart->id]);

        $duplicateProductIds = CartsProductVariants::query()
            ->select('product_variant_id')
            ->selectRaw('count(`product_variant_id`) as `productCount`')
            ->whereIn('cart_id', $cartIds)
            ->groupBy('product_variant_id')
            ->having('productCount', '>', 1)
            ->pluck('product_variant_id')->toArray();

        foreach ($duplicateProductIds as $duplicateProductId) {
            $cartProductVariant= CartsProductVariants::query()
                ->where('product_id', $duplicateProductId)
                ->whereIn('cart_id', $cartIds)
                ->get();

            /**
             * @var CartsProductVariants $firstCartProduct
             */
            $firstCartProductVariant = $cartProductVariant->first();

            foreach ($cartProductVariant as $cartProduct) {
                if ($cartProduct->id === $firstCartProductVariant->id) {
                    continue;
                }

                $firstCartProduct->count = $firstCartProductVariant->count + $cartProduct->count;
                $cartProduct->delete();
            }

            $firstCartProductVariant = $firstCartProduct->productVariants();
            if ($firstCartProduct->count > $firstCartProductVariant->quantity) {
                $firstCartProduct->count = $firstCartProductVariant->quantity;
            }

            $firstCartProduct->save();
        }
    }

    /**
     * @throws Exception
     */
    public function firstByCartIdAndProductVariantId(int $cartId, int $productVariantId): Model|Builder|null
    {
        $result = CartsProductVariants::query()->where('cart_id', $cartId);
        $this->filterProductVariant($result, $productVariantId);

        return $result->first();
    }

    /**
     * @param int $cartProductVariantsId
     * @param int $cartId
     * @return CartsProductVariants
     * @throws Exception
     */
    public function firstByIdOrFail(int $cartProductVariantsId, int $cartId): Model
    {
        $cartProductVariant = CartsProductVariants::query()
            ->where('product_variant_id', $cartProductVariantsId)
            ->where('cart_id', $cartId,)
            ->first();

        if (!$cartProductVariant) {
            throw new Exception('cart not found');
        }

        return $cartProductVariant;
    }

    /**
     * @param Builder $query
     * @param int|null $userId
     * @return void
     */
    private function filterUserId(Builder &$query, ?int $userId): void
    {
        if ($userId) {
            $query->where('user_id', $userId);
        }
    }

    /**
     * @param Builder $query
     * @param string|null $token
     * @return void
     */
    private function filterToken(Builder &$query, ?string $token): void
    {
        if ($token) {
            $query->where('token', $token);
        }
    }

    /**
     * @param Builder $query
     * @param int $productVariantId
     * @return void
     */
    private function filterProductVariant(Builder &$query, int $productVariantId): void
    {
        if ($productVariantId) {
            $query->where('product_variant_id', $productVariantId);
        }
    }

    /**
     * @param int $cartId
     * @param int $productVariantId
     * @return bool
     */
    public function removeProductVariantToCart(int $productVariantId, int $cartId): bool
    {
        $productVariant = CartsProductVariants::query()->where('product_variant_id',$productVariantId)->where('cart_id', $cartId)->first();
        if (!$productVariant) {
            throw new MatchBuilderNotFoundException(CartsProductVariants::class, $productVariantId);
        }

        $productVariant->delete();

        return true;
    }

    /**
     * @param int $cartProductVariantsId
     * @param int $cartId
     * @param int $count
     * @return CartsProductVariants
     * @throws Exception
     */
    public function addQuantity(int $cartProductVariantsId, int $cartId, int $count): CartsProductVariants
    {
        $cartProductVariant = $this->firstByIdOrFail($cartProductVariantsId, $cartId);

        $cartProductVariant->setCount($count);
        $cartProductVariant->save();

        return $cartProductVariant;
    }

    /**
     * @param Cart $cart
     * @param int $userId
     * @return Cart
     */
    public function updateUserId(Cart $cart, int $userId): Cart
    {
        $cart->user_id = $userId;
        $cart->save();

        return $cart;
    }

    /**
     * @param Cart $cart
     * @param int $productVariantId
     * @param int $count
     * @return CartsProductVariants
     */
    public function addProductToCart(Cart $cart, int $productVariantId, int $count): CartsProductVariants
    {
        $cartProductVariant = new CartsProductVariants();
        $cartProductVariant->setCartId($cart->id);
        $cartProductVariant->setProductId($productVariantId);
        $cartProductVariant->setCount($count);
        $cartProductVariant->save();
        return $cartProductVariant;
    }

    /**
     * @param Cart $cart
     * @param string $token
     * @return Cart
     */
    public function updateToken(Cart $cart, string $token): Cart
    {
        $cart->token = $token;
        $cart->save();

        return $cart;
    }
}
