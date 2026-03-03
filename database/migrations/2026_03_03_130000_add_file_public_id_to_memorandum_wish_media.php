<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `memorandum_wish_media` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `memorandum_wish_media` DROP COLUMN `file_public_id`');
    }
};
