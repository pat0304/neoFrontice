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
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->enum('lang', ['vi', 'en'])->default('en');
            $table->boolean('notifiable_comment')->default(0);
            $table->boolean('notifiable_comment_replied')->default(0);
            $table->boolean('notifiable_solution_like')->default(0);
            $table->boolean('notifiable_for_archievement')->default(0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
