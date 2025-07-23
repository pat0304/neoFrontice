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
        Schema::create('histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Ai tạo
            $table->string('action'); // Hành động: "created", "updated", "deleted", v.v.
            $table->string('model_type'); // Loại model: "Task", "Solution", "User", ...
            $table->uuid('model_id'); // ID của bản ghi
            $table->json('meta')->nullable(); // Dữ liệu bổ sung (nếu cần)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
