<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Order\CreateOrderDetailsDTO;
use App\DTO\Order\CreateOrderDTO;
use App\DTO\Order\OrderAttachProductVariantDTO;
use App\DTO\Order\OrderProductVariantDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Enums\Price\PriceTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Order\AssignUserToOrderRequest;
use App\Http\Requests\API\V1\Order\AttachProductVariantRequest;
use App\Http\Requests\API\V1\Order\ChangeOrderDeliveryStatusRequest;
use App\Http\Requests\API\V1\Order\ChangeOrderStatusRequest;
use App\Http\Requests\API\V1\Order\CreateRequest;
use App\Http\Requests\API\V1\Order\GetByIdRequest;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Resources\V1\Order\OrderResource;
use App\Managers\Order\OrderManager;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    private OrderManager $orderManager;

    /**
     * @param OrderManager $orderManager
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * @param CreateRequest $request
     * @return OrderResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): OrderResource
    {
        $productVariants = ProductVariant::query()
            ->whereIn('id', array_keys($request->getProductVariants()))
            ->get();

        $orderProductVariantDTOArray = [];

        foreach ($productVariants as $variant) {
            $orderProductVariantDTOArray[] = new OrderProductVariantDTO(
                $variant->id,
                $request->productVariants[$variant->id],
                $variant->price
            );
        }
        $orderDetailsDTO = new CreateOrderDetailsDTO(
            $request->getEmail(),
            $request->getDeliveryAddress(),
            $request->getDeliveryDate(),
            $request->getNote(),
            $request->getPhone(),
            $request->getCustomerName()
        );



        $orderDTO = new CreateOrderDTO(
            auth('api')->id(),
            600,//todo
            $orderProductVariantDTOArray,
        );

        $order = $this->orderManager->create($orderDTO, $orderDetailsDTO);
        $order->load(['variants', 'details','assignedUser','user']);
        return new OrderResource($order);
    }

    /**
     * @param GetByIdRequest $request
     * @return OrderResource
     */
    public function getByIdAction(GetByIdRequest $request): OrderResource
    {
        $order = $this->orderManager->getById($request->getId())->load([
            'assignedUser',
            'variants.options',
            'details',
            'user'
        ]);
        return new OrderResource($order);
    }

    /**
     * @param AttachProductVariantRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function attachProductVariantAction(AttachProductVariantRequest $request): JsonResponse
    {
        $orderAttachProductVariantDTO = new OrderAttachProductVariantDTO(
            $request->getOrderId(),
            $request->getProductVariantId(),
            $this->getProductVariantPrice($request->getProductVariantId(), PriceTypesEnum::DEFAULT->toString()),
            $request->getCount(),
        );
        $this->orderManager->attachProductVariant($orderAttachProductVariantDTO);

        return response()->json("Attached");
    }

    /**
     * @param int $productVariantId
     * @param string $type
     * @return mixed
     * @throws Throwable
     */
    public function getProductVariantPrice(int $productVariantId, string $type): mixed
    {
        return $this->orderManager->getProductVariantPrice($productVariantId, $type);
    }

    public function index(GetAllRequest $request)
    {
        $filterDTO = new PaginationFilterDTO(
                $request->getFilter(),
                $request->getPerPage(),
                $request->getCurrentPage(),
                []
        );

        $orders = $this->orderManager->getAll($filterDTO);

        return OrderResource::collection($orders);
    }

    public function changeDeliveryStatus(ChangeOrderDeliveryStatusRequest $request)
    {
        return $this->orderManager->changeDeliveryStatus($request->getOrderId(), $request->getOrderDeliveryStatus());
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request)
    {
        return $this->orderManager->changeOrderStatus($request->getOrderId(),$request->getOrderStatus());

    }

    public function assignUserToOrder(AssignUserToOrderRequest $request)
    {
        return $this->orderManager->assignUser($request->getOrderId(),$request->getUserId());
    }
}
