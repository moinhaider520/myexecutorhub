<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deceased_case_organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deceased_case_id')->constrained('deceased_cases')->cascadeOnDelete();
            $table->string('organisation_name');
            $table->string('organisation_type');
            $table->string('organisation_contact_name')->nullable();
            $table->string('organisation_email')->nullable();
            $table->text('organisation_address')->nullable();
            $table->string('organisation_reference')->nullable();
            $table->string('account_number')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('service_address')->nullable();
            $table->string('status')->default('suggested');
            $table->string('preferred_channel')->nullable();
            $table->string('source')->default('manual');
            $table->json('meta')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();

            $table->unique(['deceased_case_id', 'organisation_name', 'organisation_type'], 'deceased_case_org_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deceased_case_organizations');
    }
};
