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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('practice_name')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('practice_address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('relationship')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('title')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('how_acting')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['A', 'N', 'E'])->default('A');
            $table->boolean('is_online')->default(0);
            $table->string('last_activity')->nullable();
            $table->date('trial_ends_at')->nullable();
            $table->string('subscribed_package')->nullable(); // To check if the user is subscribed
            $table->string('coupon_code')->unique()->nullable(); // Store the coupon code directly
            $table->boolean('coupon_used')->default(false); // Track if the coupon has been used
            $table->decimal('commission_amount', 8, 2)->default(0); // To store the total commission earned
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('expo_token')->nullable(); // Expo token
            $table->string('user_role')->nullable(); // This field is for cron job purpose only
            $table->timestamp('last_login')->nullable()->useCurrent(); // Default to current timestamp
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
