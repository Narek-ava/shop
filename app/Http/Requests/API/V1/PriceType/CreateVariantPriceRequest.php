<?php

namespace App\Http\Requests\API\V1\PriceType;


use App\Enums\Permissions\PermissionsEnum;
use App\Enums\Currency\CurrencyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property int $variant_id
 * @property int $price_type_id
 * @property int $amount
 * @property string $currency
 */
class CreateVariantPriceRequest extends FormRequest
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
     * @return array<string, array|string>
     */
    public function rules(): array
    {
        //todo add priceTypeId ,VariantId nick check
        return [
            'variant_id'=>['required','integer'],
            'price_type_id'=>['required','integer'],
            'amount'=> ['required','integer'],
        'currency' => [new Enum(CurrencyEnum::class)]
        ];
    }
    public function getVariantId(): int
    {
        return $this->variant_id;
    }
    public function getPriceTypeId(): int
    {
        return $this->price_type_id;
    }
    public function getAmount(): int
    {
        return $this->amount;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
