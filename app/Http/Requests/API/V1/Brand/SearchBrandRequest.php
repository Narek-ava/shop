<?php

namespace App\Http\Requests\API\V1\Brand;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string $searchText
 */
class SearchBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string|array|string>
     */
    #[ArrayShape(['searchText' => 'string[]'])]
    public function rules(): array
    {
        return [
            'searchText' => ['string',  'nullable' ]
        ];
    }

    /**
     * @return string|null
     */
    public function getSearchText(): string|null
    {
        return $this->searchText;
    }
}
