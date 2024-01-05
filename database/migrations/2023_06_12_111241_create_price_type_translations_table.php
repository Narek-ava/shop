<?php

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Models\Price\PriceType;
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
        Schema::create('price_type_translations', function (Blueprint $table) {
            $table->id();
            $table->enum('locale', EnumHelper::values(LocalesEnum::cases()));
            $table->foreignId('price_type_id')->references('id')->on('price_types');
            $table->enum('field', PriceType::getTranslatableFields());
            $table->text('value');
            $table->unique(['locale', 'price_type_id', 'field']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_type_translations');
    }
};
