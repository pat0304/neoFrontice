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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('desc', 255)->nullable();
            $table->integer('default_points')->default(0);
            $table->integer('required_points')->default(0);
            $table->text('icon')->nullable();
            $table->string('background', 20)->default('#000000');
            $table->string('color', 255)->nullable('#ffffff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
