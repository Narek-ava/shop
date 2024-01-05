<?php

use App\Enums\EnumHelper;
use App\Enums\Price\PriceTypesEnum;
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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->enum('type', EnumHelper::values(PriceTypesEnum::cases()));
            $table->foreignId('product_variant_id')->references('id')->on('product_variants');
            $table->mediumText('description')->nullable();
            $table->unique(['product_variant_id', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
