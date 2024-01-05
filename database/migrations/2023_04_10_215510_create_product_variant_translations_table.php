<?php

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Models\Product\Variant\ProductVariant;
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
        Schema::create('product_variant_translations', function (Blueprint $table) {
            $table->id();
            $table->enum('locale', EnumHelper::values(LocalesEnum::cases()));
            $table->foreignId('product_variant_id')->references('id')->on('product_variants');
            $table->enum('field', ProductVariant::getTranslatableFields());
            $table->text('value');
            $table->unique(['locale', 'product_variant_id', 'field'], 'locale_variant_id_field_unique');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_translations');
    }
};
