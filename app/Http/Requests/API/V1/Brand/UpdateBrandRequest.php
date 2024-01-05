<?php

namespace App\Http\Requests\API\V1\Brand;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $position
 * @property int $id
 * @property UploadedFile $image
 */
class UpdateBrandRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [ 'string', 'max:255'],
            'slug' => [ 'string', Rule::unique('brands')->ignore(self::getId())],
            'position' => ['nullable', 'integer'],
            'image' => ['mimes:jpeg,png'],
        ];
    }

    public function getId(): int
    {
        return ( integer)$this->route()->parameter('id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return is_null($this->position) ? 0 : $this->position;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }
}
