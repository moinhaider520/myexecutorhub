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
        Schema::create('partner_self_purchase_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan_tier')->default('standard');
            $table->decimal('purchase_amount', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('reward_amount', 10, 2)->default(99.00);
            $table->unsignedInteger('qualifying_referrals_required')->default(10);
            $table->unsignedInteger('qualifying_referrals_count')->default(0);
            $table->dateTime('purchased_at');
            $table->dateTime('qualification_deadline');
            $table->dateTime('reward_granted_at')->nullable();
            $table->enum('status', ['active', 'rewarded', 'expired'])->default('active');
            $table->timestamps();

            $table->index(['partner_user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_self_purchase_campaigns');
    }
};
