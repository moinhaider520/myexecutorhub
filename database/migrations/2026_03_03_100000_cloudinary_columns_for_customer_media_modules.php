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
        DB::statement('ALTER TABLE `documents` MODIFY `file_path` LONGTEXT NOT NULL');

        DB::statement('ALTER TABLE `pictures_and_videos` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `funeral_plans` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `guidances_media` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `life_remembered_media` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `documents` MODIFY `file_path` VARCHAR(255) NOT NULL');

        DB::statement('ALTER TABLE `pictures_and_videos` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `funeral_plans` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `guidances_media` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `life_remembered_media` DROP COLUMN `file_public_id`');
    }
};

