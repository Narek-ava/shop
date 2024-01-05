<?php

namespace App\Http\Resources\V1\Order;

use App\Http\Resources\V1\ProductVariant\ProductVariantResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $email
 * @property mixed $total_amount
 * @property mixed $delivery_address
 * @property mixed $delivery_date
 * @property mixed $delivery_price
 * @property mixed $note
 * @property mixed $phone
 * @property mixed $status
 * @property mixed $created_at
 * @property mixed $delivery_status
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'orderStatus' => $this->status,
            'deliveryStatus' => $this->delivery_status,
            'deliveryPrice' => $this->delivery_price,
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'orderDetails' => new OrderDetailsResource($this->whenLoaded('details')),
            'assignedUser' => new UserResource($this->whenLoaded('assignedUser')),
            'customer' => new UserResource($this->whenLoaded('user')),
            'createdAt' => $this->created_at
        ];
    }
}
