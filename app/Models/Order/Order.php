<?php

namespace App\Models\Order;

use App\Enums\DeliveryStatus\DeliveryStatus;
use App\Enums\OrderStatuses\OrderStatusEnum;
use App\Models\OrderDetails\OrderDetails;
use App\Models\Product\Variant\ProductVariant;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 * @property string $email
 * @property float $total_amount
 * @property string $delivery_address
 * @property mixed $delivery_date
 * @property float $delivery_price
 * @property string $note
 * @property string $phone
 * @property mixed|string $customerName
 * @property mixed $detail_id
 * @property OrderStatusEnum|mixed $status
 * @property DeliveryStatus|mixed $delivery_status
 */
class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['delivery_status','status'];
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function variants(): BelongsToMany
    {
        return $this->BelongsToMany(ProductVariant::class, 'order_product_variants', 'order_id', 'product_variant_id')
        ->withPivot( 'product_price');
    }


    public function details()
    {
        return $this->hasOne(OrderDetails::class, 'id','detail_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }
}
