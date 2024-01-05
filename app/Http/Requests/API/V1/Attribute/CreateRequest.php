<?php

namespace App\Http\Requests\API\V1\Attribute;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Attribute
 * @property array $nameTranslations
 * @property bool $isFilterable
 * @property int $position
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
    #[ArrayShape(['isFilterable' => "string[]",
        'position' => "string[]",
        'nameTranslations' => "string[]",
        'nameTranslations.$locale' => "mixed"])]
    public function rules(): array
    {
        $rules = [
            'isFilterable' => ['nullable', 'boolean'],
            'position' => ['nullable', 'integer'],
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
     * @return bool
     */
    public function getIsFilterable(): bool
    {
        return is_null($this->isFilterable) ? false : $this->isFilterable;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return is_null($this->position) ? 0 : $this->position;
    }
}
