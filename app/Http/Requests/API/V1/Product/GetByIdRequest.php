<?php

namespace App\Http\Requests\API\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetByIdRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
    }
}
