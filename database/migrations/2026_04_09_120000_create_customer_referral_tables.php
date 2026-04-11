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
        Schema::create('customer_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('available_balance', 10, 2)->default(0);
            $table->decimal('pending_balance', 10, 2)->default(0);
            $table->decimal('total_earned', 10, 2)->default(0);
            $table->decimal('total_withdrawn', 10, 2)->default(0);
            $table->timestamps();

            $table->unique('user_id');
        });

        Schema::create('customer_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('customer_wallets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['credit', 'debit']);
            $table->string('category');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('completed');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_referral_invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('invited_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('invite_type');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('token')->unique();
            $table->string('referral_code')->nullable();
            $table->unsignedTinyInteger('discount_percent')->default(10);
            $table->string('status')->default('sent');
            $table->timestamp('expires_at');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('reward_pending_at')->nullable();
            $table->timestamp('reward_confirmed_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['referrer_user_id', 'invite_type']);
            $table->index(['email', 'status']);
        });

        Schema::create('customer_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('invite_id')->nullable()->constrained('customer_referral_invites')->nullOnDelete();
            $table->decimal('reward_amount', 10, 2)->default(25);
            $table->string('status')->default('pending');
            $table->timestamp('pending_until')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->timestamps();

            $table->unique(['referrer_user_id', 'referred_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_referrals');
        Schema::dropIfExists('customer_referral_invites');
        Schema::dropIfExists('customer_wallet_transactions');
        Schema::dropIfExists('customer_wallets');
    }
};
