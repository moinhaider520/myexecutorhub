<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_sources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('local_file_path')->nullable();
            $table->longText('content')->nullable();
            $table->string('openai_file_id')->nullable();
            $table->string('openai_vector_store_id')->nullable();
            $table->string('status')->default('pending');
            $table->text('error_message')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_sources');
    }
};
