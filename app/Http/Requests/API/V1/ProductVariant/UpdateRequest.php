<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $sku
 * @property mixed $published
 * @property mixed $quantity
 * @property mixed $position
 * @property mixed $nameTranslations
 * @property mixed $descriptionTranslations
 * @property mixed $shortDescriptionTranslations
 */
class UpdateRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::PRODUCT_UPDATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

    #[ArrayShape(['productId' => 'string[]',
        'sku' => 'string[]',
        'quantity' => 'string[]',
        'published' => 'string[]',
        'position' => 'string[]',
        'nameTranslations' => ['array'],
    ])]

    public function rules(): array
    {
        return [
            'sku' => ['required','string','max:255',
                Rule::unique('product_variants', 'sku')->ignore( $this->getId())],
            'published' => ['nullable', 'boolean'],
            'position' => ['nullable', 'integer'],
            'nameTranslations' => ['array'],
        ];
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
     * @return int
     */
    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
    }

    /**
     * @return array|null
     */
    public function getNameTranslations(): array|null
    {
        return $this->nameTranslations;
    }

    public function getImages(): array | null
    {
        return $this->images;
    }
}
