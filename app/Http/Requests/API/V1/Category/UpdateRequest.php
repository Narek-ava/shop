<?php

namespace App\Http\Requests\API\V1\Category;

use App\Enums\Permissions\PermissionsEnum;
use App\Models\Category\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $slug
 * @property mixed $parentId
 * @property mixed $nameTranslations
 * @property int $id
 */
class UpdateRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::CATEGORY_CREATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'slug' => ['sometimes', 'string', 'max:255', Rule::unique('categories')->ignore($this->id) ],
            'parentId' => ['sometimes', 'integer', 'exists:categories,id'],
            'nameTranslations' => ['sometimes', 'array'],

        ];
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getParentId(): int|null
    {
        return $this->parentId;
    }

    /**
     * @return array|null
     */
    public function getNameTranslations(): array|null
    {
        return $this->nameTranslations;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
    }

}
