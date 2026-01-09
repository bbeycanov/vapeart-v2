<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Check if index exists
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return count($indexes) > 0;
    }

    /**
     * Add index if not exists
     */
    private function addIndexIfNotExists(Blueprint $table, string|array $columns, string $indexName): void
    {
        if (!$this->indexExists($table->getTable(), $indexName)) {
            $table->index($columns, $indexName);
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            if (!$this->indexExists('products', 'products_is_active_index')) {
                $table->index('is_active', 'products_is_active_index');
            }
            if (!$this->indexExists('products', 'products_brand_id_index')) {
                $table->index('brand_id', 'products_brand_id_index');
            }
            if (!$this->indexExists('products', 'products_is_featured_index')) {
                $table->index('is_featured', 'products_is_featured_index');
            }
            if (!$this->indexExists('products', 'products_is_new_index')) {
                $table->index('is_new', 'products_is_new_index');
            }
            if (!$this->indexExists('products', 'products_is_hot_index')) {
                $table->index('is_hot', 'products_is_hot_index');
            }
            if (!$this->indexExists('products', 'products_stock_qty_index')) {
                $table->index('stock_qty', 'products_stock_qty_index');
            }
            if (!$this->indexExists('products', 'products_created_at_index')) {
                $table->index('created_at', 'products_created_at_index');
            }
            if (!$this->indexExists('products', 'products_deleted_at_index')) {
                $table->index('deleted_at', 'products_deleted_at_index');
            }
            if (!$this->indexExists('products', 'products_active_deleted_index')) {
                $table->index(['is_active', 'deleted_at'], 'products_active_deleted_index');
            }
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            if (!$this->indexExists('categories', 'categories_is_active_index')) {
                $table->index('is_active', 'categories_is_active_index');
            }
            if (!$this->indexExists('categories', 'categories_parent_id_index')) {
                $table->index('parent_id', 'categories_parent_id_index');
            }
            if (!$this->indexExists('categories', 'categories_deleted_at_index')) {
                $table->index('deleted_at', 'categories_deleted_at_index');
            }
        });

        // Brands table indexes
        Schema::table('brands', function (Blueprint $table) {
            if (!$this->indexExists('brands', 'brands_is_active_index')) {
                $table->index('is_active', 'brands_is_active_index');
            }
            if (!$this->indexExists('brands', 'brands_deleted_at_index')) {
                $table->index('deleted_at', 'brands_deleted_at_index');
            }
        });

        // Blogs table indexes
        Schema::table('blogs', function (Blueprint $table) {
            if (!$this->indexExists('blogs', 'blogs_is_active_index')) {
                $table->index('is_active', 'blogs_is_active_index');
            }
            if (!$this->indexExists('blogs', 'blogs_created_at_index')) {
                $table->index('created_at', 'blogs_created_at_index');
            }
            if (!$this->indexExists('blogs', 'blogs_deleted_at_index')) {
                $table->index('deleted_at', 'blogs_deleted_at_index');
            }
        });

        // Banners table indexes
        Schema::table('banners', function (Blueprint $table) {
            if (!$this->indexExists('banners', 'banners_is_active_index')) {
                $table->index('is_active', 'banners_is_active_index');
            }
            if (!$this->indexExists('banners', 'banners_position_index')) {
                $table->index('position', 'banners_position_index');
            }
            if (!$this->indexExists('banners', 'banners_type_index')) {
                $table->index('type', 'banners_type_index');
            }
            if (!$this->indexExists('banners', 'banners_deleted_at_index')) {
                $table->index('deleted_at', 'banners_deleted_at_index');
            }
        });

        // Menus table indexes
        Schema::table('menus', function (Blueprint $table) {
            if (!$this->indexExists('menus', 'menus_is_active_index')) {
                $table->index('is_active', 'menus_is_active_index');
            }
            if (!$this->indexExists('menus', 'menus_position_index')) {
                $table->index('position', 'menus_position_index');
            }
            if (!$this->indexExists('menus', 'menus_type_index')) {
                $table->index('type', 'menus_type_index');
            }
            if (!$this->indexExists('menus', 'menus_parent_id_index')) {
                $table->index('parent_id', 'menus_parent_id_index');
            }
            if (!$this->indexExists('menus', 'menus_deleted_at_index')) {
                $table->index('deleted_at', 'menus_deleted_at_index');
            }
        });

        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_is_active_index')) {
                $table->index('is_active', 'users_is_active_index');
            }
            if (!$this->indexExists('users', 'users_deleted_at_index')) {
                $table->index('deleted_at', 'users_deleted_at_index');
            }
        });

        // Widgets table indexes
        Schema::table('widgets', function (Blueprint $table) {
            if (!$this->indexExists('widgets', 'widgets_is_active_index')) {
                $table->index('is_active', 'widgets_is_active_index');
            }
            if (!$this->indexExists('widgets', 'widgets_deleted_at_index')) {
                $table->index('deleted_at', 'widgets_deleted_at_index');
            }
        });

        // Pages table indexes
        Schema::table('pages', function (Blueprint $table) {
            if (!$this->indexExists('pages', 'pages_is_active_index')) {
                $table->index('is_active', 'pages_is_active_index');
            }
            if (!$this->indexExists('pages', 'pages_deleted_at_index')) {
                $table->index('deleted_at', 'pages_deleted_at_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if ($this->indexExists('products', 'products_is_active_index')) {
                $table->dropIndex('products_is_active_index');
            }
            if ($this->indexExists('products', 'products_brand_id_index')) {
                $table->dropIndex('products_brand_id_index');
            }
            if ($this->indexExists('products', 'products_is_featured_index')) {
                $table->dropIndex('products_is_featured_index');
            }
            if ($this->indexExists('products', 'products_is_new_index')) {
                $table->dropIndex('products_is_new_index');
            }
            if ($this->indexExists('products', 'products_is_hot_index')) {
                $table->dropIndex('products_is_hot_index');
            }
            if ($this->indexExists('products', 'products_stock_qty_index')) {
                $table->dropIndex('products_stock_qty_index');
            }
            if ($this->indexExists('products', 'products_created_at_index')) {
                $table->dropIndex('products_created_at_index');
            }
            if ($this->indexExists('products', 'products_deleted_at_index')) {
                $table->dropIndex('products_deleted_at_index');
            }
            if ($this->indexExists('products', 'products_active_deleted_index')) {
                $table->dropIndex('products_active_deleted_index');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if ($this->indexExists('categories', 'categories_is_active_index')) {
                $table->dropIndex('categories_is_active_index');
            }
            if ($this->indexExists('categories', 'categories_parent_id_index')) {
                $table->dropIndex('categories_parent_id_index');
            }
            if ($this->indexExists('categories', 'categories_deleted_at_index')) {
                $table->dropIndex('categories_deleted_at_index');
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            if ($this->indexExists('brands', 'brands_is_active_index')) {
                $table->dropIndex('brands_is_active_index');
            }
            if ($this->indexExists('brands', 'brands_deleted_at_index')) {
                $table->dropIndex('brands_deleted_at_index');
            }
        });

        Schema::table('blogs', function (Blueprint $table) {
            if ($this->indexExists('blogs', 'blogs_is_active_index')) {
                $table->dropIndex('blogs_is_active_index');
            }
            if ($this->indexExists('blogs', 'blogs_created_at_index')) {
                $table->dropIndex('blogs_created_at_index');
            }
            if ($this->indexExists('blogs', 'blogs_deleted_at_index')) {
                $table->dropIndex('blogs_deleted_at_index');
            }
        });

        Schema::table('banners', function (Blueprint $table) {
            if ($this->indexExists('banners', 'banners_is_active_index')) {
                $table->dropIndex('banners_is_active_index');
            }
            if ($this->indexExists('banners', 'banners_position_index')) {
                $table->dropIndex('banners_position_index');
            }
            if ($this->indexExists('banners', 'banners_type_index')) {
                $table->dropIndex('banners_type_index');
            }
            if ($this->indexExists('banners', 'banners_deleted_at_index')) {
                $table->dropIndex('banners_deleted_at_index');
            }
        });

        Schema::table('menus', function (Blueprint $table) {
            if ($this->indexExists('menus', 'menus_is_active_index')) {
                $table->dropIndex('menus_is_active_index');
            }
            if ($this->indexExists('menus', 'menus_position_index')) {
                $table->dropIndex('menus_position_index');
            }
            if ($this->indexExists('menus', 'menus_type_index')) {
                $table->dropIndex('menus_type_index');
            }
            if ($this->indexExists('menus', 'menus_parent_id_index')) {
                $table->dropIndex('menus_parent_id_index');
            }
            if ($this->indexExists('menus', 'menus_deleted_at_index')) {
                $table->dropIndex('menus_deleted_at_index');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if ($this->indexExists('users', 'users_is_active_index')) {
                $table->dropIndex('users_is_active_index');
            }
            if ($this->indexExists('users', 'users_deleted_at_index')) {
                $table->dropIndex('users_deleted_at_index');
            }
        });

        Schema::table('widgets', function (Blueprint $table) {
            if ($this->indexExists('widgets', 'widgets_is_active_index')) {
                $table->dropIndex('widgets_is_active_index');
            }
            if ($this->indexExists('widgets', 'widgets_deleted_at_index')) {
                $table->dropIndex('widgets_deleted_at_index');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if ($this->indexExists('pages', 'pages_is_active_index')) {
                $table->dropIndex('pages_is_active_index');
            }
            if ($this->indexExists('pages', 'pages_deleted_at_index')) {
                $table->dropIndex('pages_deleted_at_index');
            }
        });
    }
};
