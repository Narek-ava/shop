<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Product\ProductVariant
 * @property int $productId
 * @property string $sku
 * @property int $quantity
 * @property int $price
 * @property bool $published
 * @property int $position
 * @property array $nameTranslations
 *\ @property mixed $images
 */
class CreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::PRODUCT_CREATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['productId' => "string[]",
        'sku' => "string[]",
        'published' => "string[]",
        'price' => 'integer[]',
        'position' => "string[]",
        'nameTranslations' => "string[]",
        'nameTranslations.$locale' => "mixed"])]
    public function rules(): array
    {
        $rules = [
            'productId' => ['required', 'integer', 'exists:products,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:product_variants,sku'],
            'published' => ['nullable', 'boolean'],
            'position' => ['nullable', 'integer'],
            'nameTranslations' => ['required', 'array'],
            'price' => ['required','integer'],
            'images' => 'array',
            'images.*' => 'mimes:jpeg,png'
        ];

        foreach (EnumHelper::values(LocalesEnum::requiredLocales()) as $locale) {
            $rules["nameTranslations.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function getPublished(): bool
    {
        return is_null($this->published) ? false : $this->published;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return is_null($this->position) ? 0 : $this->position;
    }

    /**
     * @return array
     */
    public function getNameTranslations(): array
    {
        return $this->nameTranslations;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImages(): array | null
    {
        return $this->images;
    }
}
