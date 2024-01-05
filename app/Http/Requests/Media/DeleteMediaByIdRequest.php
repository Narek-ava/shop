<?php

namespace App\Http\Requests\Media;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 */
class DeleteMediaByIdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionsEnum::PRODUCT_CREATE->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
          //
            ];
    }

    public function getId()
    {
        return (integer)$this->route()->parameter('id');
    }
}
