<?php

namespace App\Http\Requests\API\V1\Category;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Permissions\PermissionsEnum;
use App\Models\Category\Category;
use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Category
 * @property string $slug
 * @property int|null $parent_id
 * @property array $nameTranslations
 */
class CreateRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(['slug' => "string[]",
        'parent_id' => "string[]",
        'nameTranslations' => "string[]",
        "nameTranslations.*" => "string"])]
    public function rules(): array
    {
        $rules = [
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'nameTranslations' => ['required', 'array'],
        ];

        foreach (EnumHelper::values(LocalesEnum::requiredLocales()) as $locale) {
            $rules["nameTranslations.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function getNameTranslations(): array
    {
        return $this->nameTranslations;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }
}
