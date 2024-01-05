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
        Schema::create('carts_product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->references('id')->on('carts');
            $table->foreignId('product_variant_id')->references('id')->on('product_variants');
            $table->unsignedBigInteger('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product_variants');
    }
};
