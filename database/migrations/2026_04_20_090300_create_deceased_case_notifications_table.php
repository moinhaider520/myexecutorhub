<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deceased_case_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deceased_case_organization_id');
            $table->foreignId('notification_template_id')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->string('channel');
            $table->string('delivery_status')->default('draft');
            $table->string('subject_rendered')->nullable();
            $table->longText('body_rendered')->nullable();
            $table->string('pdf_path')->nullable();
            $table->json('merge_payload')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('deceased_case_organization_id', 'dcn_org_fk')
                ->references('id')
                ->on('deceased_case_organizations')
                ->cascadeOnDelete();
            $table->foreign('notification_template_id', 'dcn_template_fk')
                ->references('id')
                ->on('notification_templates')
                ->nullOnDelete();
            $table->foreign('created_by', 'dcn_created_by_fk')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deceased_case_notifications');
    }
};
