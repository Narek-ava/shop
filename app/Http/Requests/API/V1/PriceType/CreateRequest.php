<?php

namespace App\Http\Requests\API\V1\PriceType;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int|null $priority
 * @property array $descriptionTranslation
 * @property array $nameTranslations
 */
class CreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::PRODUCT_UPDATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|string>
     */
    public function rules(): array
    {
        return [
            'priority'=>['integer','nullable'],
            'descriptionTranslation'=>['array'],
            'nameTranslations'=>['required','array'],
        ];
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority ? $this->priority: 0 ;
    }
    /**
     * @return array
     */
    public function getDescriptionTranslation(): array
    {
        return $this->descriptionTranslation;
    }

    /**
     * @return array
     */
    public function getTypeTranslations(): array
    {
        return $this->nameTranslations;
    }
}
