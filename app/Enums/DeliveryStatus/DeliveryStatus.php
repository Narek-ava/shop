<?php

namespace App\Enums\DeliveryStatus;

use App\Enums\StringableEnum;

enum DeliveryStatus:string implements StringableEnum
{
    case NEW = 'new';
    case PICKED_UP_FOR_DELIVERY = 'pickedUpForDelivery';
    case IN_TRANSIT = 'inTransit';
    case READY_FOR_DELIVERY = 'readyForDelivery';
    case RETURNED = 'returned';
    case DELIVERED = 'delivered';

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    public static function statuses(): array
    {
        return self::cases();
    }
}
