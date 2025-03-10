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
        Schema::create('third_sections', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 15);
            $table->string('name', 25)->unique();
            $table->boolean('is_selected');
            $table->foreignId('background_color_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_sections');
    }
};
