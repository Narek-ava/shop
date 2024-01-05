<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CartProductVariant\AddProductVariantToCart;
use App\Http\Requests\API\V1\CartProductVariant\AddQuantityToProductCartRequest;
use App\Http\Requests\API\V1\CartProductVariant\RemoveProductToCartRequest;
use App\Http\Requests\ProductsCartRequests\AddProductToCartRequest;
use App\Managers\Cart\CartManager;
use App\Models\CartProductVariant\CartsProductVariants;
use App\Services\Cart\CartServices;
use Exception;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    protected CartServices $cartService;
    protected CartManager $cartManager;

    public function __construct(
        CartServices $cartService,
        CartManager  $cartManager
    )
    {
        $this->cartService = $cartService;
        $this->cartManager = $cartManager;
    }

    /**
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): mixed
    {
       return $this->cartManager->index();
    }

    /**
     * @param AddProductVariantToCart $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function addProductToCart(AddProductVariantToCart $request): RedirectResponse
    {
         return $this->cartManager->addProductToCart(
             $request->getProductVariantId(),
             $request->getCount()
         );
    }

    public function removeProductToCard(RemoveProductToCartRequest $request)
    {
         $this->cartManager->removeProductToCard($request->getProductVariantId(),$request->getCartId());

        return redirect(route('cart.index'));

    }

    /**
     * @throws Exception | CartsProductVariants
     */
    public  function addQuantity(AddQuantityToProductCartRequest $request): RedirectResponse
    {
        $this->cartManager->addQuantity(
            $request->getId(),
            $request->getCartId(),
            $request->getCount(),
        );

        return redirect(route('cart.index'));
    }
}
