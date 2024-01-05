<?php

namespace App\DTO\Order;

use App\DTO\DTO;

class CreateOrderDetailsDTO implements DTO
{
    public int $userId;
    public mixed $email;
    public string $deliveryAddress;
    public mixed $deliveryDate;
    public string $note;
    public string $phone;

    public string $customerName;

    /**
     * @param string $email
     * @param string $deliveryAddress
     * @param mixed $deliveryDate
     * @param string $note
     * @param string $phone
     * @param string $customerName
     */
    public function __construct(
        string $email,
        string $deliveryAddress,
        mixed $deliveryDate,
        string $note,
        string $phone,
        string $customerName
    ) {
        $this->email = $email;
        $this->deliveryAddress = $deliveryAddress;
        $this->deliveryDate = $deliveryDate;
        $this->note = $note;
        $this->phone = $phone;
        $this->customerName = $customerName;
    }
}
