<?php

use App\Models\Order\Order;
use App\Models\User\User;
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
        Schema::table('product_variant_quantity', function (Blueprint $table) {
            $table-> enum('sourceable',array(User::class,Order::class));
            $table->unsignedBigInteger('sourceable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variant_quantity', function (Blueprint $table) {
            Schema::dropIfExists('product_variant_quantity');
        });
    }
};
