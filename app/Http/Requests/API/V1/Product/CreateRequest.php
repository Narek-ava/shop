<?php

namespace App\Http\Requests\API\V1\Product;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Product
 * @property int $categoryId
 * @property int $brandId
 * @property int|null $position
 * @property bool|null $published
 * @property array $nameTranslations
 * @property array $descriptionTranslations
 * @property array $shortDescriptionTranslations
 */
class CreateRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::PRODUCT_CREATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['categoryId' => "string[]",
        'position' => "string[]",
        'published' => "string[]",
        'nameTranslations' => "string[]",
        'descriptionTranslations' => "string[]",
        'shortDescriptionTranslations' => "string[]",
        'shortDescriptionTranslations.$locale' => "mixed",
        'descriptionTranslations.$locale' => "mixed",
        'ameTranslations.$locale' => "mixed"])]
    public function rules(): array
    {
        $rules = [
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'brandId' => ['required', 'nullable', 'integer', 'exists:brands,id'],
            'position' => ['nullable', 'integer'],
            'published' => ['nullable', 'boolean'],
            'nameTranslations' => ['required', 'array'],
            'descriptionTranslations' => ['required', 'array'],
            'shortDescriptionTranslations' => ['required', 'array'],
            'images' => 'required|array|min:1',
            'images.*' => 'mimes:jpeg,png',
        ];

        foreach (EnumHelper::values(LocalesEnum::requiredLocales()) as $locale) {
            $rules["nameTranslations.$locale"] = ['required', 'string', 'max:255'];
            $rules["descriptionTranslations.$locale"] = ['required', 'string', 'max:255'];
            $rules["shortDescriptionTranslations.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return int
     */
    public function getBrandId(): int
    {
        return $this->brandId;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return is_null($this->position) ? 0 : $this->position;
    }

    /**
     * @return bool
     */
    public function getPublished(): bool
    {
        return is_null($this->published) ? false : $this->published;
    }

    /**
     * @return array
     */
    public function getNameTranslations(): array
    {
        return $this->nameTranslations;
    }

    /**
     * @return array
     */
    public function getDescriptionTranslations(): array
    {
        return $this->descriptionTranslations;
    }

    /**
     * @return array
     */
    public function getShortDescriptionTranslations(): array
    {
        return $this->shortDescriptionTranslations;
    }
}
