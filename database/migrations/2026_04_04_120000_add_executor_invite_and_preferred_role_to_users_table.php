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
            $table->string('preferred_role')->nullable()->after('user_role');
            $table->string('executor_invite_token')->nullable()->after('preferred_role');
            $table->timestamp('executor_invited_at')->nullable()->after('executor_invite_token');
            $table->timestamp('executor_activated_at')->nullable()->after('executor_invited_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'preferred_role',
                'executor_invite_token',
                'executor_invited_at',
                'executor_activated_at',
            ]);
        });
    }
};
