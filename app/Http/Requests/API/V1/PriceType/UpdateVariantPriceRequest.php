<?php

namespace App\Http\Requests\API\V1\PriceType;

use App\Enums\Currency\CurrencyEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property mixed $variant_id
 * @property mixed $price_type_id
 * @property mixed $amount
 * @property mixed $currency
 */
class UpdateVariantPriceRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount'=> ['sometimes','integer','nullable'],
        ];
    }

    /**
     * @return int|null
     */
    public function getAmount(): int|null
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
    }
}
