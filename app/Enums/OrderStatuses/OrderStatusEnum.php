<?php

namespace App\Enums\OrderStatuses;

use App\Enums\StringableEnum;

enum OrderStatusEnum:string implements StringableEnum
{

    case NEW = 'new';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case READY_FOR_DELIVERY = 'readyForDelivery';
    case ON_THE_WAY = 'onTheWay';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case DECLINED = 'declined';
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
