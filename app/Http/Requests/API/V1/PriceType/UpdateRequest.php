<?php

namespace App\Http\Requests\API\V1\PriceType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $priority
 * @property mixed $descriptionTranslation
 * @property mixed $nameTranslations
 */
class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return ['priority' => ['sometimes', 'integer', 'nullable'],
            'descriptionTranslation' => ['array'],
            'nameTranslations' => ['sometimes', 'array'],];
    }

    /**
     * @return int|null
     */
    public function getPriority(): int|null
    {
        return $this->priority ? $this->priority : 0;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
    }

}
