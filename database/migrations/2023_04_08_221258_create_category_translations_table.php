<?php

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Models\Category\Category;
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
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->enum('locale', EnumHelper::values(LocalesEnum::cases()));
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->enum('field', Category::getTranslatableFields());
            $table->text('value');
            $table->unique(['locale', 'category_id', 'field']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};
