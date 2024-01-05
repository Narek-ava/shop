<?php
namespace App\Services\Product;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\CreateProductDTO;
use App\DTO\Product\UpdateProductDTO;
use App\Models\Product\Product;
use App\Models\Product\ProductTranslation;
use Dflydev\DotAccessData\Data;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProductService
 * @package App\Services\Product
 */
class ProductService
{
    /**
     * @param CreateProductDTO $createProductDTO
     * @return Product
     */
    public function create(CreateProductDTO $createProductDTO): Product
    {
        $product = new Product();
        $product->category_id = $createProductDTO->categoryId;
        $product->position = $createProductDTO->position;
        $product->published = $createProductDTO->published;
        $product->brand_id = $createProductDTO->brandId;
        $product->save();

        foreach ($createProductDTO->productTranslationsDTO as $productTranslationDTO) {
            $productTranslation = new ProductTranslation();
            $productTranslation->product_id = $product->id;
            $productTranslation->locale = $productTranslationDTO->locale;
            $productTranslation->field = $productTranslationDTO->field;
            $productTranslation->value = $productTranslationDTO->text;
            $productTranslation->save();
        }

        return $product;
    }

    /**
     * @param UpdateProductDTO $updateProductDTO
     * @return Model
     */
    public function update(UpdateProductDTO $updateProductDTO): Product
    {
        $updateProduct = Product::query()->where('id', $updateProductDTO->productId)->first();
        $updateProduct->position = $updateProductDTO->position;
        $updateProduct->published = $updateProductDTO->published;
        $updateProduct->brand_id = $updateProductDTO->brandId;
        $updateProduct->save();

        foreach ($updateProductDTO->translations as $translations) {
            ProductTranslation::query()
                ->updateOrCreate([
                    'product_id' => $translations->productId,
                    'field' => $translations->field,
                    'locale' => $translations->locale->toString()
                ], [
                    'value' => $translations->text
                ]);
        }

        if ($updateProductDTO->images) {
            $images = $updateProductDTO->images;
            foreach ($images as $image) {
                $updateProduct->addMedia($image)->toMediaCollection('images');
            }
        }
        return $updateProduct;
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Product
     */
    public function find(int $id, array $relations = []): Product
    {
        /** @var Product $product */
        $product = Product::query()->with($relations)->findOrFail($id);

        return $product;
    }


    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return Product::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }
}
