<?php

namespace App\Http\Requests\API\V1\PromoCode;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $code
 * @property int|null $discountAmount
 * @property int|null $discountPercent
 * @property int $maxUses
 * @property mixed $expiredAt
 * @property array|null $productVariantId
 */
class PromoCodeRequest extends FormRequest
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
        return [
            'code' => ['sometimes', 'nullable', 'string ', 'min:8', 'max:12'],
            'maxUses' => ['required', 'integer'],
            'discountAmount' => ['required_without:discountPercent', 'integer', 'nullable'],
            'discountPercent' => ['required_Without:discountAmount', 'integer', 'nullable', 'max:100'],
            'expiredAt' => ['required', 'date', 'after_or_equal:start_date'],
            'productVariantId' => ['sometimes', 'array'],
            'productVariantId.*' => ['required','integer', 'exists:product_variants,id']
        ];
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        if (!$this->code) {
            return Str::random(10);
        }
        return $this->code;

    }

    /**
     * @return int|null
     */
    public function getDiscountAmount(): ?int
    {
        return $this->discountAmount;
    }

    /**
     * @return int|null
     */
    public function getDiscountPercent(): ?int
    {
        return $this->discountPercent;
    }

    /**
     * @return int
     */
    public function getMaxUses(): int
    {
        return $this->maxUses;
    }

    /**
     * @return Carbon
     */
    public function getExpiredAt(): Carbon
    {
        return Carbon::parse($this->expiredAt);
    }

    /**
     * @return array
     */
    public function getProductVariantId(): array
    {
        return $this->productVariantId;
    }
}
