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
        DB::statement('ALTER TABLE `wish_media` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `life_remembered_video_media` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `videos` ADD COLUMN `file_public_id` VARCHAR(255) NULL AFTER `file_path`');
        DB::statement('ALTER TABLE `voice_notes` ADD COLUMN `voice_note_public_id` VARCHAR(255) NULL AFTER `voice_note`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `wish_media` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `life_remembered_video_media` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `videos` DROP COLUMN `file_public_id`');
        DB::statement('ALTER TABLE `voice_notes` DROP COLUMN `voice_note_public_id`');
    }
};
