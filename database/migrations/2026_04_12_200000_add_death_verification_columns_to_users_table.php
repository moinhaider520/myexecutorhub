<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('contact_number');
            $table->date('date_of_death')->nullable()->after('date_of_birth');
            $table->enum('death_verification_status', ['not_started', 'pending_review', 'verified', 'rejected'])
                ->default('not_started')
                ->after('date_of_death');
            $table->timestamp('deceased_verified_at')->nullable()->after('death_verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'date_of_death',
                'death_verification_status',
                'deceased_verified_at',
            ]);
        });
    }
};
