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
        Schema::create('footer_social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25)->unique();
            $table->string('url');
            $table->string('icon', 45)->unique();
            $table->boolean('is_selected');
            $table->integer('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_social_media_links');
    }
};
