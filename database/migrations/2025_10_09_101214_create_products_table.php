<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();

            $table->string('sku')->nullable();
            $table->string('slug')->unique();

            $table->json('name');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();

            $table->decimal('price', 12, 2);
            $table->decimal('compare_at_price', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');

            $table->unsignedInteger('stock_qty')->default(0);
            $table->boolean('is_track_stock')->default(true);

            $table->json('attributes')->nullable();
            $table->json('specs')->nullable();

            $table->unsignedInteger('reviews_count')->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_hot')->default(false);

            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes('deleted_at')->nullable();

            $table->index([
                'brand_id',
                'is_active'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
