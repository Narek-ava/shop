<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTagRequest extends FormRequest
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
            'id' => $this->route('id')
        ]);

        return [
            'id' => 'integer|exists:product_variant_tags',
        ];
    }
}
