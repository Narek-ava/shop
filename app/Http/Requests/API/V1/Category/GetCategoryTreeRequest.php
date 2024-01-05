<?php

namespace App\Http\Requests\API\V1\Category;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class GetCategoryTreeRequest
 * @package App\Http\Requests\API\V1\Category
 * @property array|null $categoryIds
 */
class GetCategoryTreeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['categoryIds' => "string[]", 'categoryIds.*' => "string[]"])] public function rules(): array
    {
        return [
            'categoryIds' => ['nullable', 'array'],
            'categoryIds.*' => ['sometimes', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return array
     */
    public function getCategoryIds(): array
    {
        return $this->get('categoryIds', []);
    }
}
