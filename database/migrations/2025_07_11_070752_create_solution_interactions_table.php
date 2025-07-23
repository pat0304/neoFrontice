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
        Schema::create('solutions_interactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('solution_id');
            $table->string('interact', 10);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('solution_id')->references('id')->on('solutions');
            $table->unique(['user_id', 'solution_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solution_interactions');
    }
};
