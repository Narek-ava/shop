<?php

namespace App\Http\Requests\API\V1\CartProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $count
 * @property int $cartId
 */
class AddQuantityToProductCartRequest extends FormRequest
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
        $this->merge([
            'id' => $this->route('id'),

        ]);

        return [
            'id' => ['required', 'integer', 'exists:product_variants,id'],
            'cartId' => ['required', 'integer', 'exists:carts,id'],
            'count' => ['required', 'integer']
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getCartId(): int
    {
        return $this->cartId;
    }
}
