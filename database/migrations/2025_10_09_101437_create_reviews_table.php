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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->morphs('reviewable'); // reviewable_id, reviewable_type
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->unsignedTinyInteger('rating')->default(5); // 1..5
            $table->string('title')->nullable();
            $table->text('body')->nullable();

            $table->unsignedTinyInteger('status')->default(1); // 0=pending,1=approved,2=spam
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['reviewable_id','reviewable_type','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
