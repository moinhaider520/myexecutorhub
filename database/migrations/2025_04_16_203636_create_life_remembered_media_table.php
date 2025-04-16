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
        Schema::create('life_remembered_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('life_remembered_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('life_remembered_media');
    }
};
