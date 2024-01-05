<?php

namespace App\Http\Requests\API\V1\CartProductVariant;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int $productVariantId
 * @property int $count
 */
class AddProductVariantToCart extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string |array|string>
     */
    #[ArrayShape(['productVariantId' => "string[]", 'count' => "string[]"])]
    public function rules(): array
    {
        return [
            'productVariantId'=>['required','int'],
            'count'=>['required','int']
        ];
    }
    public function getProductVariantId():int
    {
        return $this->productVariantId;
    }
    public function getCount():int
    {
        return $this->count;
    }
}
