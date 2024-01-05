<?php

namespace App\Http\Requests\API\V1\FavoritesProduct;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $id
 */
class FavoritesProductDeleteRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'=>['required','integer',],
        ];
    }
    public function getId(): int
    {
        return $this->id;
    }
}
