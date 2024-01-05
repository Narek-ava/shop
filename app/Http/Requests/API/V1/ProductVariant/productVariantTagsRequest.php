<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $productVariantId
 * @property mixed $tags
 */
class productVariantTagsRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'tags' => ['sometimes', 'string', 'max:255'],

        ];
    }

    public function getProductVariantId(): int
    {
        return $this->productVariantId;
    }

    /**
     * @return string|null
     */
    public function getTags(): string|null
    {
        return $this->tags;
    }
}
