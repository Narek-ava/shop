<?php

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Models\Product\Product;
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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->enum('locale', EnumHelper::values(LocalesEnum::cases()));
            $table->foreignId('product_id')->references('id')->on('products');
            $table->enum('field', Product::getTranslatableFields());
            $table->text('value');
            $table->unique(['locale', 'product_id', 'field']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
