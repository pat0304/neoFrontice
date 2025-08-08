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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('username', 50)->unique();
            // $table->string('password')->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('provider', 50)->nullable();
            $table->string('provider_id', 100)->unique()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('block_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
