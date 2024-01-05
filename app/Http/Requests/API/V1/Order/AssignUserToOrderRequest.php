<?php

namespace App\Http\Requests\API\V1\Order;

use App\Enums\EnumHelper;
use App\Enums\OrderStatuses\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class AssignUserToOrderRequest extends FormRequest
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
            'orderId' => $this->route('orderId'),
        ]);


        return [
            'orderId' => ['required','integer','exists:orders,id'],
            'userId' => ['required','integer','exists:users,id'],
        ];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }
}
