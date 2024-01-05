<?php

namespace App\Http\Requests\API\V1\Option;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string $searchText
 * @property int $attributeId
 */
class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string|array|string>
     */
    public function rules(): array
    {
        return [
            'searchText'=>['required','string'],
            'attributeId' => ['int']
        ];
    }

    /**
     * @return string
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }

    /**
     * @return int
     */
    public function getAttributeId(): int | null
    {
        return $this->attributeId;
    }
}
