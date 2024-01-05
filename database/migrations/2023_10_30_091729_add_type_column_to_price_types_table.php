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
        Schema::table('price_types', function (Blueprint $table) {
            $table->enum('type', [EnumHelper::values(PriceTypesEnum::cases())]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_types', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
