<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $quantity
 */
class QuantityRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        $this->merge([
            'id' => $this->route('id')
        ]);

        $this->validate([
            'quantity' => [
                'numeric',//todo
                function ($attribute, $value, $fail) {
                    $maxValue = DB::table('product_variant_quantity')
                        ->where('product_variant_id', (int) $this->id)
                        ->sum('quantity');
                        if ($maxValue === 0){
                            ProductVariant::query()->where('id',$this->id)->update([
                                 'out_of_stock' => false
                            ]);
                        }
                    if (abs($this->getQuantity()) > $maxValue && $this->getQuantity() < 0 ) {
                        $fail("The $attribute must be less than or equal to $maxValue.");
                    }
                },
            ],
        ]);

        return [
            'id' => ['required', 'integer', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer'],
        ];
    }
    public function getQuantity(): int
    {
       return $this->quantity;
    }
}
