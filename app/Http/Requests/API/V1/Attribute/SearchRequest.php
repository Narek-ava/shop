<?php

namespace App\Http\Requests\API\V1\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string $searchText
 */
class SearchRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array|string>
     */
    #[ArrayShape([
        'searchText' => 'string[]',
    ])]
    public function rules(): array
    {
        return ['searchText' => 'required', 'string'];
    }

    /**
     * @return string
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }
}
