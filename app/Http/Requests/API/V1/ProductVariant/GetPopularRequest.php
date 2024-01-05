<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $limit
 */
class GetPopularRequest extends FormRequest
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
            'limit' => ['sometimes', 'integer']
        ];
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
