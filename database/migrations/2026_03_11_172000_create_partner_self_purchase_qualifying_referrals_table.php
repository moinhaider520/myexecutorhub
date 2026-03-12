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
        Schema::create('partner_self_purchase_qualifying_referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('partner_user_id');
            $table->unsignedBigInteger('referred_customer_user_id');
            $table->string('qualifying_plan_tier');
            $table->dateTime('qualified_at');
            $table->timestamps();

            $table->unique(['campaign_id', 'referred_customer_user_id'], 'partner_self_purchase_unique_referral');
            $table->foreign('campaign_id', 'pspqr_campaign_fk')
                ->references('id')
                ->on('partner_self_purchase_campaigns')
                ->cascadeOnDelete();
            $table->foreign('partner_user_id', 'pspqr_partner_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('referred_customer_user_id', 'pspqr_customer_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_self_purchase_qualifying_referrals');
    }
};
