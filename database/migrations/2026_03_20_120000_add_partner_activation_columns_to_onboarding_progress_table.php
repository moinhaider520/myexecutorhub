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
        Schema::table('onboarding_progress', function (Blueprint $table) {
            $table->unsignedTinyInteger('partner_activation_step')->default(0)->after('picture_uploaded');
            $table->timestamp('partner_activation_completed_at')->nullable()->after('partner_activation_step');
            $table->timestamp('partner_activation_notified_at')->nullable()->after('partner_activation_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onboarding_progress', function (Blueprint $table) {
            $table->dropColumn([
                'partner_activation_step',
                'partner_activation_completed_at',
                'partner_activation_notified_at',
            ]);
        });
    }
};
