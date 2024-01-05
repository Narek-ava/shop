<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AttachOptionRequest
 * @package App\Http\Requests\API\V1\ProductCariant
 * @property int $productVariantId
 * @property int $optionId
 */
class AttachOptionRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(['productVariantId' => "string[]", 'optionId' => "string[]"])]
    public function rules(): array
    {
        return [
            'productVariantId' => ['required', 'integer', 'exists:product_variants,id'],
            'optionId' => ['required', 'integer', 'exists:options,id'],
        ];
    }

    /**
     * @return int
     */
    public function getProductVariantId(): int
    {
        return $this->productVariantId;
    }

    /**
     * @return int
     */
    public function getOptionId(): int
    {
        return $this->optionId;
    }
}
