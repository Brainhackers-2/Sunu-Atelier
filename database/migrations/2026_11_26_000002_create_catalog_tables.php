<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('header_image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('techniques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('village', 120);
            $table->string('craft_specialty');
            $table->text('bio')->nullable();
            $table->string('portrait_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('artisan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technique_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku', 60)->unique();
            $table->enum('availability_type', ['en_stock', 'piece_unique', 'sur_commande'])->default('en_stock')->index();
            $table->unsignedSmallInteger('manufacturing_days')->nullable();
            $table->unsignedInteger('price_public');
            $table->unsignedInteger('price_compare_at')->nullable();
            $table->unsignedInteger('price_pro')->nullable();
            $table->unsignedInteger('weight_grams')->default(500);
            $table->string('dimensions', 120)->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('materials_story')->nullable();
            $table->text('care_instructions')->nullable();
            $table->text('authenticity_guarantee')->nullable();
            $table->string('model_3d_path')->nullable();
            $table->boolean('is_bestseller')->default(false)->index();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('material_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'material_id']);
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size', 60)->nullable();
            $table->string('color', 60)->nullable();
            $table->string('material_label', 80)->nullable();
            $table->string('sku_suffix', 40)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('material_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('artisans');
        Schema::dropIfExists('techniques');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('categories');
    }
};
