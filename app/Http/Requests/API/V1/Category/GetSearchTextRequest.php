<?php

namespace App\Http\Requests\API\V1\Category;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string|null $searchText
 * @property int|null $limit
 */
class GetSearchTextRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string array|string>
     */
    #[ArrayShape(['searchText' => "string[]", 'limit' => "string[]"])] public function rules(): array
    {
        return [
            'searchText' => ['sometimes', 'string'],
            'limit' => ['sometimes', 'number'],
        ];
    }

    public function getSearchText(): string|null
    {
        return $this->searchText;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
