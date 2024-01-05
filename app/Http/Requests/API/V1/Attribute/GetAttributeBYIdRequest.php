<?php

namespace App\Http\Requests\API\V1\Attribute;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $attributeId
 */
class GetAttributeBYIdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->merge([
            'attributeId' => $this->route('attributeId'),
        ]);

        return [
            'attributeId' => ['required', 'integer', 'exists:attributes,id'],
        ];
    }

    public function getAttributeId(): int
    {
        return $this->attributeId;
    }
}
