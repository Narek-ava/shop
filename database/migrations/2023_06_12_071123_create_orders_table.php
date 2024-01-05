<?php

use App\Enums\DeliveryStatus\DeliveryStatus;
use App\Enums\EnumHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email')->nullable();
            $table->enum('status',
                EnumHelper::values(DeliveryStatus::cases())
                )->default(DeliveryStatus::NEW->toString());
            $table->float('total_amount')->nullable();
            $table->string('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->float('delivery_price')->nullable();
            $table->text('note')->nullable();
            $table->text('phone')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
