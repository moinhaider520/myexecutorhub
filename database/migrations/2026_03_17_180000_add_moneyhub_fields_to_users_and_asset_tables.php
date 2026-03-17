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
        Schema::table('users', function (Blueprint $table) {
            $table->string('moneyhub_user_id')->nullable()->after('remember_token');
            $table->timestamp('moneyhub_user_created_at')->nullable()->after('moneyhub_user_id');
        });

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('source')->default('manual')->after('balance');
            $table->string('moneyhub_account_id')->nullable()->after('source');
            $table->string('moneyhub_connection_id')->nullable()->after('moneyhub_account_id');
            $table->string('masked_account_number')->nullable()->after('moneyhub_connection_id');
            $table->longText('moneyhub_payload')->nullable()->after('masked_account_number');
            $table->timestamp('moneyhub_synced_at')->nullable()->after('moneyhub_payload');
        });

        Schema::table('investment_accounts', function (Blueprint $table) {
            $table->string('source')->default('manual')->after('balance');
            $table->string('moneyhub_account_id')->nullable()->after('source');
            $table->string('moneyhub_connection_id')->nullable()->after('moneyhub_account_id');
            $table->longText('moneyhub_payload')->nullable()->after('moneyhub_connection_id');
            $table->timestamp('moneyhub_synced_at')->nullable()->after('moneyhub_payload');
        });

        Schema::table('debt_and_liabilities', function (Blueprint $table) {
            $table->string('source')->default('manual')->after('amount_outstanding');
            $table->string('moneyhub_account_id')->nullable()->after('source');
            $table->string('moneyhub_connection_id')->nullable()->after('moneyhub_account_id');
            $table->longText('moneyhub_payload')->nullable()->after('moneyhub_connection_id');
            $table->timestamp('moneyhub_synced_at')->nullable()->after('moneyhub_payload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('debt_and_liabilities', function (Blueprint $table) {
            $table->dropColumn([
                'source',
                'moneyhub_account_id',
                'moneyhub_connection_id',
                'moneyhub_payload',
                'moneyhub_synced_at',
            ]);
        });

        Schema::table('investment_accounts', function (Blueprint $table) {
            $table->dropColumn([
                'source',
                'moneyhub_account_id',
                'moneyhub_connection_id',
                'moneyhub_payload',
                'moneyhub_synced_at',
            ]);
        });

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn([
                'source',
                'moneyhub_account_id',
                'moneyhub_connection_id',
                'masked_account_number',
                'moneyhub_payload',
                'moneyhub_synced_at',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'moneyhub_user_id',
                'moneyhub_user_created_at',
            ]);
        });
    }
};
