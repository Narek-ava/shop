<?php

namespace App\Http\Requests\API\V1\Attribute;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property array | null $nameTranslations
 * @property bool $isFilterable
 * @property int $position
 */
class UpdateAttributeRequest extends FormRequest
{
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
            'isFilterable' => ['nullable', 'boolean'],
            'position' => ['sometimes', 'integer'],
            'nameTranslations' => ['sometimes', 'array'],
        ];
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
        return ( integer)$this->route()->parameter('attributeId');
    }

    /**
     * @return bool
     */
    public function getIsFilterable(): bool
    {
        return $this->isFilterable;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}
