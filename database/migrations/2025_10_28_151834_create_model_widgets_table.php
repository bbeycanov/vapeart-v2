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
        Schema::create('model_widgets', function (Blueprint $table) {
            $table->id();

            // Polymorphic model
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            // Normal foreign key
            $table->foreignId('widget_id')->constrained('widgets')->onDelete('cascade');

            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_widgets');
    }
};
