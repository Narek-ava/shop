<?php

namespace App\Http\Requests\API\V1\Order;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int $orderId
 * @property int $productVariantId
 * @property int $count
 */
class AttachProductVariantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    #[ArrayShape(['orderId' => "string[]",
        'productVariantId' => "string[]",
        'count' => "string[]"])]
    public function rules(): array
    {
        return [
            'orderId' => ['required', 'integer', 'exists:orders,id'],
            'productVariantId' => ['required', 'exists:product_variants,id'],
            'count' => ['sometimes', 'integer'],
        ];
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
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
    public function getCount(): int
    {
        return $this->count;
    }
}
