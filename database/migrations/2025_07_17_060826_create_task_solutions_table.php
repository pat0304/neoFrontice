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
        Schema::create('task_solutions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('task_id');
            $table->string('title', 255)->nullable();
            $table->text('desc');
            $table->string('github_url')->nullable();
            $table->string('live_page')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->boolean('is_viewed')->default(false);
            $table->string('tasker_review', 1000)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_solutions');
    }
};
