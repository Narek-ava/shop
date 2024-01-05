<?php

namespace App\Managers\Order;

use App\DTO\Order\CreateOrderDetailsDTO;
use App\DTO\Order\CreateOrderDTO;
use App\DTO\Order\OrderAttachProductVariantDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Models\Order\Order;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderManager
{
    protected OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param CreateOrderDTO $createOrderDTO
     * @return Order
     * @throws Throwable
     */
    public function create(CreateOrderDTO $createOrderDTO, CreateOrderDetailsDTO $createOrderDetailsDTO): Order
    {
        DB::beginTransaction();
        try {
            $order = $this->orderService->create($createOrderDTO, $createOrderDetailsDTO);
            DB::commit();

            return $order;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return Order
//     * @throws ModelNotFoundException
     */
    public function getById(int $id): Order
    {
        return $this->orderService->getById($id);
    }

    /**
     * @param OrderAttachProductVariantDTO $orderAttachProductVariantDTO
     * @return void
     */
    public function attachProductVariant(OrderAttachProductVariantDTO $orderAttachProductVariantDTO)
    {
        $this->orderService->attachProductVariant($orderAttachProductVariantDTO);
    }

    /**
     * @param int $productVariantId
     * @param string $type
     * @return mixed
     * @throws Throwable
     */
    public function getProductVariantPrice(int $productVariantId, string $type): mixed
    {
        try {
            return $this->orderService->getProductVariantPrice($productVariantId, $type);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param int $orderId
     *
     * @return float|null
     */
    public function getTotalAmount(int $orderId): ?float
    {
        return $this->orderService->getTotalAmount($orderId);
    }

    public function getAll(PaginationFilterDTO $paginationFilterDTO)
    {
        return $this->orderService->getAll($paginationFilterDTO);
    }

    public function changeDeliveryStatus(int $id, string $status)
    {
        return $this->orderService->changeDeliveryStatus($id,$status);
    }

    public function changeOrderStatus(int $id, string $status)
    {
      return  $this->orderService->changeOrderStatus($id,$status);

    }

    public function assignUser(int $orderId, int $userId)
    {
        return $this->orderService->assignUser($orderId,$userId);
    }
}
