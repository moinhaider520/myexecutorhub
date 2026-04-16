<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('death_certificate_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('death_certificate_verifications', 'document_sha256')) {
                $table->dropColumn('document_sha256');
            }

            if (!Schema::hasColumn('death_certificate_verifications', 'bdb')) {
                $table->string('bdb')->nullable()->after('duplicate_of_verification_id')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('death_certificate_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('death_certificate_verifications', 'bdb')) {
                $table->dropColumn('bdb');
            }

            if (!Schema::hasColumn('death_certificate_verifications', 'document_sha256')) {
                $table->string('document_sha256', 64)->nullable()->after('duplicate_of_verification_id')->index();
            }
        });
    }
};
