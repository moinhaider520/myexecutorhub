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
        Schema::create('will_user_accounts_properties', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type')->nullable();
            $table->string('asset_name')->nullable();
            $table->string('mortage')->nullable();
            $table->string('owner')->nullable();
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
        Schema::dropIfExists('will_user_accounts_properties');
    }
};
