<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->string('sku', 50)->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2)->unsigned();
            $table->longText('description')->nullable();
            $table->string('dimensions', 150)->nullable();
            $table->string('material')->default('100% Tanaman Mansiang Alami');
            $table->text('usage_instructions')->nullable();
            $table->enum('availability_status', ['ready_stock', 'pre_order', 'out_of_stock'])->default('ready_stock');
            $table->unsignedInteger('estimated_production_days')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('primary_image');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'is_active', 'availability_status']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
