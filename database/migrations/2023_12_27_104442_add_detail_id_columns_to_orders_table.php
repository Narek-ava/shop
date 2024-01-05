<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->foreign('detail_id')->references('id')->on('order_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
                    Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_detail_id_foreign');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('detail_id');
        });
        });
    }
};
