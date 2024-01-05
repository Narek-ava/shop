<?php

use App\Enums\Currency\CurrencyEnum;
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
        Schema::create('variant_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->references('id')->on('product_variants');
            $table->foreignId('price_type_id')->references('id')->on('price_types');
            $table->unsignedBigInteger('amount');
            $table->enum('currency', EnumHelper::values(CurrencyEnum::cases()));
            $table->unique(['variant_id','price_type_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_price');
    }
};
