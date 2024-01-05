<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $variantId
 * @property bool $available
 */
class CheckAvailableStatusRequest extends FormRequest
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
            'variantId' => ['required', 'integer', 'exists:product_variants,id'],
            'available' => 'required|bool'
        ];
    }

    /**
     * @return int
     */
    public function getVariantId():int
    {
        return $this->variantId;
    }

    /**
     * @return bool
     */
    public function getAvailable():bool
    {
        return $this->available;
    }
}
