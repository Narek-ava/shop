<?php

namespace App\Http\Requests\API\V1\Order;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetByIdRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize():bool
    {
        return $this->user()->can(PermissionsEnum::ORDER_VIEW->toString());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
    }
}
