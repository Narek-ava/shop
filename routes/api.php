<?php

use App\Http\Controllers\API\Auth\PasswordResetController;
use App\Http\Controllers\API\V1\AttributeController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\CartController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\FavoritesProductController;
use App\Http\Controllers\API\V1\OptionController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\PriceController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ProductVariantController;
use App\Http\Controllers\API\V1\ProductVariantsTagsController;
use App\Http\Controllers\API\V1\PromoCodeController;
use App\Http\Controllers\API\V1\ReviewController;
use App\Http\Controllers\API\V1\RolesController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);
});

Route::get('/health-check', function () {
    return response()->json(['status' => 'ok']);
});
Route::post('/forgot-password', [PasswordResetController::class,'sendResetLinkEmail'])->middleware('guest')->name('password.email');

Route::post('/reset-password', [PasswordResetController::class,'reset'])->middleware('guest');



Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
Route::middleware('auth:api')->group(function () {
    Route::prefix('roles')->as('role.')->group(function () {
        Route::get('/{id}', [RolesController::class, 'find'])->name('find');
    });
    Route::prefix('categories')->as('category.')->group(function () {
        Route::post('/', [CategoryController::class, 'createAction'])->name('create');
        Route::patch('/{id}', [CategoryController::class, 'update'])->name('update');
    });

    Route::prefix('users')->as('user.')->group(function () {
        Route::get('/auth-user', [UserController::class, 'getAuthUserAction'])->name('getAuthUser');
        Route::post('/image',[UserController::class,'updateOrCreateUserImage'])->name('createUserImage');
        Route::delete('/delete/image',[UserController::class,'deleteImage'])->name('deleteImage');
        Route::get('/logOut',[UserController::class,'logOut'])->name('logOut');
        Route::get('/',[UserController::class,'index'])->name('index');
        Route::get('/search',[UserController::class,'userSearch'])->name('searchAction');
        Route::get('/{id}',[UserController::class,'find'])->name('findAction');
    });

    Route::prefix('products')->as('product.')->group(function () {
        Route::post('/', [ProductController::class, 'createAction'])->name('create');
        Route::patch('/{id}',[ProductController::class,'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'deleteImage']);
    });

    Route::prefix('product-variants')->as('productVariant.')->group(function () {
        Route::post('/', [ProductVariantController::class, 'createAction'])->name('create');
        Route::post('/{id}/quantity',[ProductVariantController::class,'addQuantityAction'])->name('quantity');
        Route::post('/attach-option',[ProductVariantController::class,'attachOptionAction'])->name('attachOption');
        Route::post('/detach-option',[ProductVariantController::class,'detachOptionAction'])->name('detachOption');
        Route::post('/{id}',[ProductVariantController::class,'updateAction'])->name('update');
        Route::get('/variant/quantity',[ProductVariantController::class,'getQuantityByIdAction'])->name('getQuantity');
        Route::delete("/{id}",[ProductVariantController::class,'deleteImage'])->name('deleteImgById');
        Route::post('/check/available',[ProductVariantController::class,'checkAvailableStatus'])->name('checkAvailable');
        Route::get('/popular',[ProductVariantController::class,'getPopular'])->name('getPopular');
        Route::post('/check/published',[ProductVariantController::class,'checkPublishedStatus'])->name('checkPublishedStatus');
    });

    Route::prefix('reviews')->as('review')->group(function () {
        Route::post('/', [ReviewController::class, 'review'])->name('review');
        Route::get('/', [ReviewController::class, 'index'])->name('index');

    });

    Route::prefix('attributes')->as('attribute.')->group(function () {
        Route::patch('/{attributeId}',[AttributeController::class,'update'])->name('update');
        Route::post('/', [AttributeController::class, 'createAction'])->name('create');
        Route::get('/search',[AttributeController::class,'searchAction'])->name('search');
        Route::get('/{attributeId}',[AttributeController::class,'getById']);
    });

    Route::prefix('options')->as('option.')->group(function () {
        Route::post('/', [OptionController::class, 'createAction'])->name('create');
        Route::get('/search',[OptionController::class,'searchAction'])->name('search');
        Route::delete('/{id}',[OptionController::class,'deleteAction'])->name('delete');
        Route::get('/{id}',[OptionController::class,'findAction'])->name('find');

    });

    Route::prefix('brands')->as('brand.')->group(function () {
        Route::post('/', [BrandController::class, 'createAction'])->name('create');
        Route::patch('/{id}',[BrandController::class,'updateAction'])->name('update');
        Route::delete('/{brandId}/images/{imageId}', [BrandController::class, 'deleteImage']);
    });

    Route::prefix('promo-codes')->as('promoCode')->group(function (){
       Route::post('/',[PromoCodeController::class,'createPromoCode'])->name('promoCode');
    });

    Route::prefix('favorites')->as('favorite.')->group(function (){
        Route::post('/create',[FavoritesProductController::class,'createAction'])->name('create');
        Route::post('/delete',[FavoritesProductController::class,'deleteAction'])->name('delete');
        Route::get('/',[FavoritesProductController::class,'getProductAction'])->name('get');
    });

    Route::prefix('favorites')->as('favorite.')->group(function (){
        Route::post('/create',[FavoritesProductController::class,'createAction'])->name('create');
        Route::post('/delete',[FavoritesProductController::class,'deleteAction'])->name('delete');
        Route::get('/',[FavoritesProductController::class,'getProductAction'])->name('get');
    });

    Route::prefix('carts')->as('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/product_variants', [CartController::class, 'addProductToCart'])->name('addToCart');
        Route::delete('/remove/product',[CartController::class,'removeProductToCard'])->name('removeToCart');
        Route::patch('/{id}/addCount', [CartController::class, 'addQuantity'])->name('addQuantity');

    });

    Route::prefix('tags')->as('tag')->group(function (){
        Route::post('/', [ProductVariantsTagsController::class, 'createAction'])->name('create');
        Route::delete('/{id}',[ProductVariantsTagsController::class, 'deleteTagById'])->name('delete');
    });

    Route::prefix('orders')->as('order.')->group(function () {
        Route::get('/attach', [OrderController::class, 'attachProductVariantAction'])->name('attach'); //todo check need
        Route::get('/{id}', [OrderController::class, 'getByIdAction'])->name('getOrder');
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/change/status/{orderId}', [OrderController::class, 'changeOrderStatus'])->name('changStatus');
        Route::post('/change/delivery/status/{orderId}', [OrderController::class, 'changeDeliveryStatus'])->name('changeDeliveryStatus');
        Route::post('/assign/user/{orderId}', [OrderController::class, 'assignUserToOrder'])->name('changeDeliveryStatus');
    });
});

Route::prefix('categories')->as('category.')->group(function () {
    Route::get('/search', [CategoryController::class, 'searchAction']);
    Route::get('/getCategoryTree', [CategoryController::class, 'getCategoryTree'])->name('categoryTreeAction');
    Route::get('/getPopular', [CategoryController::class, 'getPopularAction'])->name('popularAction');
    Route::get('/{id}', [CategoryController::class, 'findAction'])->name('popularAction');
    Route::get('/', [CategoryController::class, 'index'])->name('index');

});

Route::prefix('products')->as('product.')->group(function () {
    Route::get('/{id}', [ProductController::class, 'findAction'])->name('findAction');
    Route::get('/', [ProductController::class, 'index'])->name('index');

});

Route::prefix('users')->as('user.')->group(function () {
    Route::post('/', [UserController::class, 'createAction'])->name('create');
});

Route::prefix('price-type')->as('priceType.')->group(function () {
    Route::post('/', [PriceController::class, 'createPriceType'])->name('create');
    Route::get('/get-type',[PriceController::class, 'getPriceType'])->name('getType');
    Route::post('/variant-price',[PriceController::class, 'createVariantPrice'])->name('variantPrice');
    Route::patch('/{id}',[PriceController::class,'update'])->name('update');
    Route::patch('/update-variant/{id}',[PriceController::class,'updateVariantPrice'])->name('updateVariantPrice');
});

Route::prefix('brands')->as('brand.')->group(function () {
    Route::get('/search',[BrandController::class,'searchAction'])->name('search');
    Route::get('/getPopular',[BrandController::class,'getPopularAction'])->name('popularAction');
    Route::get('/{id}', [BrandController::class, 'findAction'])->name('find');
    Route::get('/', [BrandController::class, 'index'])->name('index');
});

Route::prefix('product-variants')->as('productVariant.')->group(function () {
    Route::get('/search',[ProductVariantController::class,'searchAction'])->name('search');
    Route::get('/{id}',[ProductVariantController::class,'findAction'])->name('find');
    Route::get('/price', [ProductVariantController::class, 'getPrice'])->name('getPrice'); //todo remove
});
Route::prefix('attributes')->as('attribute.')->group(function () {
    Route::get('/', [AttributeController::class, 'index'])->name('index');
});
Route::prefix('orders')->as('order.')->group(function () {
    Route::post('/', [OrderController::class, 'createAction'])->name('create');
});

Route::get('payments/ameria', [PaymentController::class, 'ameriaCallback'])->name('payment.ameriaCallback');
