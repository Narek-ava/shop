<?php

namespace App\Http\Requests\API\V1\ProductVariant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $searchText
 * @property int|null $limit
 */
class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'searchText' => ['required', 'string'],
            'limit' => ['sometimes', 'numeric'],
        ];
    }

    public function getSearchText(): string
    {
        return $this->searchText;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
