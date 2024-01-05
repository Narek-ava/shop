<?php

namespace App\Http\Requests\API\V1\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 */
class FindUserRequest extends FormRequest
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
            'id' => $this->route('id')
        ]);

        return [
            'id' => 'required|integer'
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
