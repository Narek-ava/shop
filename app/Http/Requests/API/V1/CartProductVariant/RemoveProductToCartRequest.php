<?php

namespace App\Http\Requests\API\V1\CartProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $cartId
 * @property int $variantId
 */
class RemoveProductToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cartId' => ['required', 'integer', 'exists:carts,id'],
            'variantId'=> ['required', 'integer', 'exists:product_variants,id']
        ];
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getProductVariantId(): int
    {
        return $this->variantId;
    }
}
