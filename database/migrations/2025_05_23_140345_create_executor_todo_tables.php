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
        Schema::create('executor_todo_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('order');
            $table->enum('type', ['standard', 'advanced'])->default('standard');
            $table->timestamps();
        });

        Schema::create('executor_todo_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('executor_todo_stages')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('executor_todo_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_item_id')->constrained('executor_todo_items')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['not_completed', 'completed', 'not_required'])->default('not_completed');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['todo_item_id', 'user_id', 'created_by'], 'unique_todo_progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executor_todo_progress');
        Schema::dropIfExists('executor_todo_items');
        Schema::dropIfExists('executor_todo_stages');
    }
};