<?php

namespace App\Http\Resources\V1\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $customer_name
 * @property string $delivery_address
 * @property string $delivery_date
 * @property string $note
 * @property string $phone
 */
class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customerName' => $this->customer_name,
            'deliveryAddress' => $this->delivery_address,
            'deliveryDate' => $this->delivery_date,
            'note' => $this->note,
            'phone' =>$this->phone,
        ];
    }
}
