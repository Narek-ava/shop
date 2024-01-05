<?php

namespace App\Http\Requests\API\V1\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int|null $limit
 */
class GetPopularRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'number']
        ];
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
