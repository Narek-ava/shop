<?php

namespace App\Http\Requests\API\V1\Order;

use App\Enums\DeliveryStatus\DeliveryStatus;
use App\Enums\EnumHelper;
use App\Enums\OrderStatuses\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $orderStatus
 */
class ChangeOrderStatusRequest extends FormRequest
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
            'orderStatus' => ['required', 'string', 'in:' . implode(',', EnumHelper::values(OrderStatusEnum::statuses()))]
        ];
    }

    public function getOrderStatus(): string
    {
        return $this->orderStatus;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }
}
