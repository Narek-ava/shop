<?php

namespace App\Http\Requests\API\V1\FavoritesProduct;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property int $productVariantId
 */
class FavoritesProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'productVariantId' => ['required','integer'],
            'userId' => ['required','integer'],
        ];
    }

    public function getProductVariantId(): int
    {
       return $this->productVariantId;
    }

    public function getUserId(): int
    {
       return $this->userId;
    }
}
