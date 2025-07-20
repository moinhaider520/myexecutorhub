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
        Schema::create('will__user__infos', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('martial_status')->nullable();
            $table->string('children')->nullable();
            $table->string('pets')->nullable();

            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will__user__infos');
    }
};
