<?php

namespace App\Http\Requests\API\V1\Pagination;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $perPage
 * @property int $currentPage
 * @property array | null $filter
 */
class GetAllRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $this->validate([
            'page' => 'integer',
            'perPage' => 'integer',
        ]);

        return [
            'filter' => 'array',
            'filter.*' =>'integer'
        ];
    }

    /**
     * @return int|null
     */
    public function getPerPage(): int | null
    {
        return $this->input('perPage');
    }

    /**
     * @return int|null
     */
    public function getCurrentPage(): int | null
    {
        return $this->input('page');
    }

    public function getFilter(): array | null
    {
        return $this->filter;
    }
}
