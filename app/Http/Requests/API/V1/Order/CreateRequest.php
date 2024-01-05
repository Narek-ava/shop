<?php

namespace App\Http\Requests\API\V1\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string $email
 * @property string $deliveryAddress
 * @property mixed $deliveryDate
 * @property string $note
 * @property string $phone
 * @property array $productVariants
 * @property string $customerName
 * @property int $assignedUserId
 */
class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'deliveryAddress' => ['required', 'string'],
            'deliveryDate' => ['required', 'date'],
            'note' => ['sometimes', 'max:3000'],
            'phone' => ['sometimes', 'max:30'],
            'assignedUserId' =>['required', 'integer', 'exists:users,id'],
            'customerName' => ['required','string']
            //todo product variant validation
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
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
    public function getDeliveryAddress(): string
    {
        return $this->deliveryAddress;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate(): mixed
    {
        return $this->deliveryDate;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array
     *
     */
    public function getProductVariants(): array
    {
        return $this->productVariants;
    }

    public function getCustomerName():string
    {
        return $this->customerName;
    }

    public function getAssignedUserId():int
    {
        return $this->assignedUserId;
    }
}
