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
        Schema::create('will__user__estate__inherited__agencies', function (Blueprint $table) {
            $table->id();
            $table->string('agency_name')->nullable();
            $table->string('percentage_estate')->nullable();
            $table->foreignId('user_estate_will_id')->references('id')->on('will__user__estates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will__user__estate__inherited__agencies');
    }
};
