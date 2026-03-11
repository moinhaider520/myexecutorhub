<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_partner_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('partner_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('mailbox_email')->unique();
            $table->string('requested_local_part');
            $table->enum('provision_status', ['pending', 'active', 'failed'])->default('pending');
            $table->string('provider')->default('cpanel');
            $table->timestamp('provisioned_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->unique('customer_user_id');
            $table->unique('partner_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_partner_accounts');
    }
};
