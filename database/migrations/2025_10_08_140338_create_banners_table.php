<?php

use App\Enums\BannerType;
use App\Enums\BannerPosition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('position')->default(BannerPosition::HOME_HERO_SLIDESHOW->value); // enum string
            $table->string('type')->default(BannerType::IMAGE->value);                       // enum string
            $table->string('key')->unique();

            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('content')->nullable();
            $table->json('html')->nullable();
            $table->json('link_text')->nullable();
            $table->json('link_url')->nullable();


            $table->string('target')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes('deleted_at')->nullable();

            $table->index([
                'position',
                'type',
                'is_active',
                'starts_at',
                'ends_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
