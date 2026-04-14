<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('death_certificate_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('processing_status', ['queued', 'processing', 'completed', 'failed'])->default('queued');
            $table->enum('verification_status', [
                'pending',
                'manual_review',
                'auto_verified',
                'rejected',
                'approved_by_admin',
                'rejected_by_admin',
            ])->default('pending');
            $table->string('analysis_version')->default('v1');
            $table->string('ocr_provider')->nullable();
            $table->longText('ocr_raw_text')->nullable();
            $table->decimal('ocr_confidence', 5, 2)->nullable();
            $table->json('extracted_data')->nullable();
            $table->json('normalized_data')->nullable();
            $table->json('document_checks')->nullable();
            $table->json('match_checks')->nullable();
            $table->json('fraud_checks')->nullable();
            $table->json('mismatch_reasons')->nullable();
            $table->unsignedSmallInteger('confidence_score')->nullable();
            $table->text('hard_fail_reason')->nullable();
            $table->unsignedBigInteger('duplicate_of_verification_id')->nullable();
            $table->string('document_sha256', 64)->nullable()->index();
            $table->string('uploaded_file_name')->nullable();
            $table->unsignedBigInteger('uploaded_file_size')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->unique('document_id');
            $table->foreign('duplicate_of_verification_id', 'dcv_duplicate_verification_fk')
                ->references('id')
                ->on('death_certificate_verifications')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('death_certificate_verifications');
    }
};
