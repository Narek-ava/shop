<?php

namespace App\Models\OrderDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $email
 * @property mixed|string $delivery_address
 * @property mixed $delivery_date
 * @property mixed|string $note
 * @property mixed|string $phone
 * @property mixed|string $customer_name
 */
class OrderDetails extends Model
{
    use HasFactory;
}
