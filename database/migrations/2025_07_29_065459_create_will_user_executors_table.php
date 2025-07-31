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
        Schema::create('will_user_executors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('will_user_info_id')->references('id')->on('will_user_infos')->onDelete('cascade');
            $table->foreignId('executor_id')->references('id')->on('will_inherited_people')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will_user_executors');
    }
};
