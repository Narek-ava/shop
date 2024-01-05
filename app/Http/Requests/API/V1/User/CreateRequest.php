<?php

namespace App\Http\Requests\API\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\V1\User
 * @property string $name
 * @property string $email
 * @property string $password
 * @property mixed $role
 * @property mixed|string $assignRole
 * @property UploadedFile | null $image
 */
class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string[]", 'email' => "string[]", 'password' => "string[]"])] public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:255']
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPasswordValue(): string
    {
        return $this->password;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): UploadedFile | null
    {
        return $this->image;
    }
}
