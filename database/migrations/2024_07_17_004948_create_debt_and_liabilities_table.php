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
        Schema::create('debt_and_liabilities', function (Blueprint $table) {
            $table->id();
            $table->string('debt_type');
            $table->string('reference_number');
            $table->string('loan_provider');
            $table->string('contact_details');
            $table->decimal('amount_outstanding', 15, 2);
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
        Schema::dropIfExists('debt_and_liabilities');
    }
};
