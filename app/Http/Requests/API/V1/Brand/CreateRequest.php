<?php

namespace App\Http\Requests\API\V1\Brand;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\UploadedFile;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\Brand
 * @property string $name
 * @property string $slug
 * @property int|null $position
 * @property UploadedFile $image
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
    #[ArrayShape(['name' => "string[]", 'slug' => "string[]", 'position' => "string[]" , 'image'=> "string"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique('brands')->ignore($this->id)],
            'position' => ['nullable', 'integer'],
            'image' => 'required|mimes:jpeg,png',
        ];
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

    public function getImage(): UploadedFile
    {
        return $this->image;
    }
}
