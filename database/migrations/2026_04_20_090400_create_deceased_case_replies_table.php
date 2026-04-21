<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deceased_case_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deceased_case_organization_id');
            $table->foreignId('deceased_case_notification_id')->nullable();
            $table->foreignId('logged_by')->nullable();
            $table->string('reply_status')->default('reply_received');
            $table->string('mapping_outcome')->nullable();
            $table->string('mapped_entity_type')->nullable();
            $table->unsignedBigInteger('mapped_entity_id')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->date('received_at')->nullable();
            $table->text('summary')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->foreign('deceased_case_organization_id', 'dcr_org_fk')
                ->references('id')
                ->on('deceased_case_organizations')
                ->cascadeOnDelete();
            $table->foreign('deceased_case_notification_id', 'dcr_notification_fk')
                ->references('id')
                ->on('deceased_case_notifications')
                ->nullOnDelete();
            $table->foreign('logged_by', 'dcr_logged_by_fk')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deceased_case_replies');
    }
};
