<?php

namespace App\Http\Requests\API\V1\Option;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Attribute
 * @property int $attributeId
 * @property array $nameTranslations
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
    #[ArrayShape(['attributeId' => "string[]",
        'nameTranslations' => "string[]",
        'nameTranslations.$locale' => "mixed"])]
    public function rules(): array
    {
        $rules = [
            'attributeId' => ['required', 'integer', 'exists:attributes,id'],
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
     * @return int
     */
    public function getAttributeId(): int
    {
        return $this->attributeId;
    }
}
