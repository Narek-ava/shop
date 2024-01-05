<?php

namespace App\Managers\Cart;

use App\Http\Resources\V1\Cart\CartResource;
use App\Models\CartProductVariant\CartsProductVariants;
use App\Services\Cart\CartServices;
use Exception;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartManager
{
    protected CartServices $cartService;
    public function __construct(CartServices $cartServices)
    {
        $this->cartService = $cartServices;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
   {
       $cart = getCarts()->first();
       $cart->load(['productVariants']);
       $cart->productVariants->load(['nameTranslations']);

       return new CartResource($cart);
   }

    /**
     * @param int $productVariantId
     * @param int $count
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function addProductToCart(int $productVariantId, int $count):RedirectResponse
    {
       $cart = getCarts()->first();
       if (!$this->cartService->firstByCartIdAndProductVariantId($cart->id, $productVariantId)) {
           $this->cartService->addProductToCart(
               $cart,
               $productVariantId,
               $count,
           );
       }

       return redirect(route('cart.index'));
   }


    public function removeProductToCard(int $variantId, int $cartId)
    {
        return $this->cartService->removeProductVariantToCart($variantId,$cartId);

    }

    /**
     * @throws Exception | CartsProductVariants
     */
    public function addQuantity(int $cartProductVariantsId, int $cartId, int $count): CartsProductVariants
    {
        return $this->cartService->addQuantity($cartProductVariantsId,$cartId,$count);
    }
}
