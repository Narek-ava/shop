<?php

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Models\Attribute\Option\Option;
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
        Schema::create('option_translations', function (Blueprint $table) {
            $table->id();
            $table->enum('locale', EnumHelper::values(LocalesEnum::cases()));
            $table->foreignId('option_id')->references('id')->on('options');
            $table->enum('field', Option::getTranslatableFields());
            $table->text('value');
            $table->unique(['locale', 'option_id', 'field']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_translations');
    }
};
