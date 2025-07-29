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
        Schema::create('will_user_funerals', function (Blueprint $table) {
            $table->id();
            $table->string('funeral_type')->nullable();
            $table->string('funeral_paid')->nullable();
            $table->string('funeral_wish')->nullable();
            $table->string('funeral_direct_cremation')->nullable();
            $table->string('funeral_provider_name')->nullable();
            $table->string('funeral_identification_no')->nullable();
            $table->string('funeral_paid_guide')->nullable();
            $table->text('additional')->nullable();
            $table->foreignId('will_user_id')->references('id')->on('will_user_infos')->onDelete('cascade');
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will_user_funerals');
    }
};
