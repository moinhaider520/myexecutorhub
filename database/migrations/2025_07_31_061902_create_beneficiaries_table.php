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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('will_user_id')->references('id')->on('will_user_infos')->onDelete('cascade');
            $table->morphs('beneficiable');
            $table->decimal('share_percentage', 5, 2)->default(0.00); 
            $table->enum('death_backup_plan', ['their_children', 'split_remaining'])->nullable();
            $table->string('death_backup_name')->nullable();
            $table->unique(['will_user_id', 'beneficiable_id', 'beneficiable_type'], 'will_beneficiaries_unique_beneficiary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
