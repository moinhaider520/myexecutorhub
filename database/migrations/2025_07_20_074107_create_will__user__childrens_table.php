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
        Schema::create('will__user__childrens', function (Blueprint $table) {
            $table->id();
            $table->string('child_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->foreignId('will_user_id')->references('id')->on('will__user__infos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will__user__childrens');
    }
};
