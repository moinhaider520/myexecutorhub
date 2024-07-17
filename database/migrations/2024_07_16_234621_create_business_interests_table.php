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
        Schema::create('business_interests', function (Blueprint $table) {
            $table->id();
            $table->string('business_type');
            $table->string('business_name');
            $table->decimal('shares', 5, 2);
            $table->decimal('business_value', 15, 2);
            $table->decimal('share_value', 15, 2);
            $table->string('contact');
            $table->string('plan_for_shares');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_interests');
    }
};
