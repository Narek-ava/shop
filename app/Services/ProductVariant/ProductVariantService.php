<?php
namespace App\Services\ProductVariant;

use App\DTO\ProductVariant\CheckAvailableStatusDTO;
use App\DTO\ProductVariant\CheckPublishedStatusDTO;
use App\DTO\ProductVariant\CreateProductVariantDTO;
use App\DTO\ProductVariant\ProductVariantAttachOptionDTO;
use App\DTO\ProductVariant\ProductVariantDetachOptionDTO;
use App\DTO\ProductVariant\UpdateProductVariantDTO;
use App\Enums\Currency\CurrencyEnum;
use App\Enums\Price\PriceTypesEnum;
use App\Models\Brand\Brand;
use App\Models\Price\PriceType;
use App\Models\Product\Variant\ProductVariant;
use App\Models\Product\Variant\ProductVariantPrice;
use App\Models\Product\Variant\ProductVariantTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * Class ProductVariantService
 * @package App\Services\ProductVariant
 */
class ProductVariantService
{
    /**
     * @param CreateProductVariantDTO $createProductVariantDTO
     * @return ProductVariant
     */
    public function create(CreateProductVariantDTO $createProductVariantDTO): ProductVariant
    {
        $productVariant = new ProductVariant();
        $productVariant->product_id = $createProductVariantDTO->productId;
        $productVariant->sku = $createProductVariantDTO->sku;
        $productVariant->position = $createProductVariantDTO->position;
        $productVariant->published = $createProductVariantDTO->published;
        $productVariant->save();

        foreach ($createProductVariantDTO->productVariantTranslationsDTO as $productVariantTranslationDTO) {
            $productVariantTranslation = new ProductVariantTranslation();
            $productVariantTranslation->product_variant_id = $productVariant->id;
            $productVariantTranslation->locale = $productVariantTranslationDTO->locale;
            $productVariantTranslation->field = $productVariantTranslationDTO->field;
            $productVariantTranslation->value = $productVariantTranslationDTO->text;
            $productVariantTranslation->save();
        }

        $productVariantPrice = new ProductVariantPrice();
        $productVariantPrice->variant_id = $productVariant->id;
        //todo
        $productVariantPrice->price_type_id = PriceType::query()
            ->where('type', PriceTypesEnum::DEFAULT->toString())
            ->first()
            ->id;
        $productVariantPrice->amount = $createProductVariantDTO->price;
        $productVariantPrice->currency = CurrencyEnum::defaultCurrency()->toString();
        $productVariantPrice->save();

        if ($createProductVariantDTO->images) {
            $images = $createProductVariantDTO->images;
            foreach ($images as $image) {
                $productVariant->addMedia($image)->toMediaCollection('images');
            }
        }

        return $productVariant;
    }

    /**
     * @param UpdateProductVariantDTO $updateProductVariantDTO
     * @return Model|Builder|null
     */
    public function update(UpdateProductVariantDTO $updateProductVariantDTO): Model|Builder|null
    {
        $updateProductVariant = new ProductVariant();
        $updateProductVariant = $updateProductVariant->query()
            ->where('id', $updateProductVariantDTO->productVariantId)->first();
        $updateProductVariant->sku = $updateProductVariantDTO->sku;
        $updateProductVariant->published = $updateProductVariantDTO->published;
        $updateProductVariant->position = $updateProductVariantDTO->position;
        $updateProductVariant->update();

        foreach ($updateProductVariantDTO->translations as $translations) {
            $translationModel = ProductVariantTranslation::query()
                ->updateOrCreate([
                    'product_variant_id' => $translations->productId,
                    'field' => $translations->field,
                    'locale' => $translations->locale->toString()
                ], [
                    'value' => $translations->text
                ]);
        }

        if ($updateProductVariantDTO->images) {
            $images = $updateProductVariantDTO->images;
            foreach ($images as $image) {
                $updateProductVariant->addMedia($image)->toMediaCollection('images');
            }
        }
        return $updateProductVariant;
    }

    /**
     * @param ProductVariantAttachOptionDTO $productVariantAttachOptionDTO
     * @return void
     */
    public function attachOption(ProductVariantAttachOptionDTO $productVariantAttachOptionDTO): void
    {
        /** @var ProductVariant $productVariant */
        $productVariant = ProductVariant::query()->findOrFail($productVariantAttachOptionDTO->productVariantId);
        $productVariant->options()->detach($productVariantAttachOptionDTO->optionId);
        $productVariant->options()->attach($productVariantAttachOptionDTO->optionId, [], false);
    }


    /**
     * @param ProductVariantDetachOptionDTO $productVariantDetachOptionDTO
     * @return void
     */
    public function detachOption(ProductVariantDetachOptionDTO $productVariantDetachOptionDTO): void
    {
        /** @var ProductVariant $productVariant */
        $productVariant = ProductVariant::query()->findOrFail($productVariantDetachOptionDTO->productVariantId);
        $productVariant->options()->detach($productVariantDetachOptionDTO->optionId);
    }

    /**
     * @param string $searchText
     * @param int $limit
     * @param array $relations
     * @return Collection|ProductVariant[]
     */
    public function search(string $searchText, int $limit, array $relations = []): Collection|array
    {
        return ProductVariant::query()->with($relations)->whereHas('translations', function (Builder $query) use ($searchText) {
            $query->where('value', 'LIKE', "%$searchText%");
        })->limit($limit)->get();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return ProductVariant|Collection
     * @throws ModelNotFoundException
     */
    public function find(int $id = 10, array $relations = []): ProductVariant|Collection
    {
        return ProductVariant::query()->with($relations)->findOrFail($id);
    }

    public function checkAvailableStatus(CheckAvailableStatusDTO $availableStatusDTO): JsonResponse
    {
         ProductVariant::query()->where('id',$availableStatusDTO->variantId)->update([
            'available' => $availableStatusDTO->available
        ]);
         return response()->json([
             'message' => 'Status checked'
         ]);
    }

    public function getPopular(array $relations = [], int | null $limit = 10): Collection|array
    {
        return ProductVariant::query()
        ->with($relations)
        ->selectRaw('COUNT(product_variants.id) as created_at, product_variants.id as id, product_variants.product_id, product_variants.published, product_variants.position, product_variants.available, product_variants.out_of_stock, product_variants.sku')
        ->groupBy('product_variants.id', 'product_variants.sku', 'product_variants.created_at')
        ->orderByDesc('created_at')->limit($limit)->get();
    }

    public function checkPublishedStatus(CheckPublishedStatusDTO $checkPublishedStatusDTO): JsonResponse
    {
        ProductVariant::query()->where('id',$checkPublishedStatusDTO->variantId)->update([
            'published' => $checkPublishedStatusDTO->published
        ]);
        return response()->json([
            'message' => 'Status checked'
        ]);
    }

}
