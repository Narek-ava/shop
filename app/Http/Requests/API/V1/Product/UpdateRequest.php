<?php

namespace App\Http\Requests\API\V1\Product;

use App\Enums\Permissions\PermissionsEnum;
use App\Models\Product\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $descriptionTranslations
 * @property mixed $published
 * @property mixed $brandId
 * @property mixed $position
 * @property mixed $nameTranslations
 * @property mixed $shortDescriptionTranslations
 * @property mixed $images
 */
class UpdateRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'brandId' => ['sometimes', 'nullable', 'integer', 'exists:brands,id'],
            'position' => ['nullable', 'integer'],
            'published' => ['nullable', 'boolean'],
            'nameTranslations' => ['array'],
            'descriptionTranslations' => ['array'],
            'shortDescriptionTranslations' => ['array'],
            'images' => 'array',
            'images.*' => 'mimes:jpeg,png'
        ];
    }

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
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


    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
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

    public function getImages():array | null
    {
        return $this->images;
    }
}
