<?php

namespace App\Services\Order;

use App\DTO\Order\CreateOrderDetailsDTO;
use App\DTO\Order\CreateOrderDTO;
use App\DTO\Order\OrderAttachProductVariantDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Enums\DeliveryStatus\DeliveryStatus;
use App\Enums\OrderStatuses\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\OrderDetails\OrderDetails;
use App\Models\Product\Variant\ProductVariant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    /**
     * @param CreateOrderDTO $createOrderDTO
     * @return Order
     */
    public function create(CreateOrderDTO $createOrderDTO, CreateOrderDetailsDTO $createOrderDetailsDTO): Order
    {
        $totalAmount = $createOrderDTO->deliveryPrice;
        $productVariantIds = [];

        foreach ($createOrderDTO->orderProductVariants as $orderProductVariantDTO) {
            $productVariantIds[$orderProductVariantDTO->productVariantId] = [
                'product_price' => $orderProductVariantDTO->price,
                'count' => $orderProductVariantDTO->quantity,
            ];
            $totalAmount += $orderProductVariantDTO->price * $orderProductVariantDTO->quantity;
        }

        $orderDetails = new OrderDetails();
        $orderDetails->email = $createOrderDetailsDTO->email;
        $orderDetails->delivery_address = $createOrderDetailsDTO->deliveryAddress;
        $orderDetails->delivery_date = $createOrderDetailsDTO->deliveryDate;
        $orderDetails->note = $createOrderDetailsDTO->note;
        $orderDetails->phone = $createOrderDetailsDTO->phone;
        $orderDetails->customer_name = $createOrderDetailsDTO->phone;
        $orderDetails->save();

        $order = new Order();
        $order->user_id = $createOrderDTO->userId;
        $order->total_amount = $totalAmount;
        $order->delivery_price = $createOrderDTO->deliveryPrice;
        $order->detail_id = $orderDetails->id;
        $order->status = OrderStatusEnum::NEW;
        $order->delivery_status = DeliveryStatus::NEW;
        $order->save();

        $order->variants()->sync($productVariantIds);

        return $order;
    }

    /**
     * @param int $id
     * @return Order
     * @throws ModelNotFoundException
     * @noinspection PhpUnnecessaryLocalVariableInspection
     */
    public function getById(int $id): Order
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($id);

        return $order;
    }

    /**
     * @param OrderAttachProductVariantDTO $orderAttachProductVariantDTO
     * @return void
     */
    public function attachProductVariant(OrderAttachProductVariantDTO $orderAttachProductVariantDTO): void
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($orderAttachProductVariantDTO->orderId);
        $order->variants()->attach($orderAttachProductVariantDTO->productVariantId, [
            'product_price' => $orderAttachProductVariantDTO->productPrice,
            'count' => $orderAttachProductVariantDTO->count
        ]);
        $order->save();
    }

    /**
     * @param int $productVariantId
     * @param string $type
     * @return mixed
     * @throws Exception
     */
    public function getProductVariantPrice(int $productVariantId, string $type): mixed
    {
        $productVariantPrices = ProductVariant::query()->findOrFail($productVariantId);

        $productPrices = $productVariantPrices->prices->pluck('amount', 'type')->toArray();

        if (array_key_exists($type, $productPrices)) {
            return $productPrices[$type];
        } else {
            throw new Exception("Product price not found");
        }
    }

    /**
     * @param int $orderId
     *
     * @return float|null
     */
    public function getTotalAmount(int $orderId): ?float
    {
        $order = Order::query()->findOrFail($orderId);

//        return $order->total_amount;
        return 63;//todo
    }

    public function getAll(PaginationFilterDTO $paginationFilterDTO)
    {
        return Order::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }

    public function changeDeliveryStatus(int $id, string $status)
    {
        $order = Order::query()->findOrFail($id);
        $order->delivery_status = $status;

        $order->save();

        return response()->json([
            'message' => "Delivery status checked successfully"
        ]);

    }

    public function changeOrderStatus(int $id, string $status)
    {
        $order = Order::query()->findOrFail($id);
        $order->status = $status;

        $order->save();

        return response()->json([
            'message' => "Order status checked successfully"
        ]);

    }

    public function assignUser(int $orderId, int $userId)
    {
        $order = Order::query()->findOrFail($orderId);
        $order->assigned_user_id = $userId;

        $order->save();

        return response()->json([
            'message' => "Assigned successfully"
        ]);
    }
}
