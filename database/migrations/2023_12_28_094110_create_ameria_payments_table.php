<?php

use App\Models\AmeriaPayment\AmeriaPayment;
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
        Schema::create('ameria_payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->enum('currency', [
                AmeriaPayment::CURRENCY_AMD,
            ]);
            $table->string('external_id')->nullable();
            $table->enum('status', [
                AmeriaPayment::STATUS_PENDING,
                AmeriaPayment::STATUS_PROCESSING,
                AmeriaPayment::STATUS_APPROVED,
                AmeriaPayment::STATUS_REJECTED,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ameria_payments');
    }
};
