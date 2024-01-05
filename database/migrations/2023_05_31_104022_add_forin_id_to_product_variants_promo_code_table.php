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
        Schema::table('product_variants_promo_code', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->references('id')->on('product_variants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants_promo_code', function (Blueprint $table) {

            $table->dropForeign('product_variants_promo_code_product_variant_id_foreign');
            $table->dropColumn('product_variant_id');
        });
    }
};
