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
            $table->dropForeign('orders_user_id_foreign');
        });

        // Now, you can drop the 'user_id' column
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn('delivery_address');
            $table->dropColumn('delivery_date');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('note');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
