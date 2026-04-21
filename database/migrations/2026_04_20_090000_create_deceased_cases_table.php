<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deceased_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('death_certificate_verification_id')->nullable()->constrained('death_certificate_verifications')->nullOnDelete();
            $table->foreignId('opened_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('case_reference')->unique();
            $table->string('status')->default('open');
            $table->string('deceased_title')->nullable();
            $table->string('deceased_first_name')->nullable();
            $table->string('deceased_last_name')->nullable();
            $table->string('deceased_full_name')->nullable();
            $table->date('deceased_date_of_birth')->nullable();
            $table->date('deceased_date_of_death')->nullable();
            $table->string('deceased_last_address_line_1')->nullable();
            $table->string('deceased_last_address_line_2')->nullable();
            $table->string('deceased_last_address_city')->nullable();
            $table->string('deceased_last_address_postcode')->nullable();
            $table->string('deceased_national_insurance_number')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('probate_status')->nullable();
            $table->date('grant_issue_date')->nullable();
            $table->date('letters_of_administration_issue_date')->nullable();
            $table->string('authority_document_type')->nullable();
            $table->json('snapshot')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->unique('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deceased_cases');
    }
};
