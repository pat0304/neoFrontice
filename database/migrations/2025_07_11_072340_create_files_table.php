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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->ulidMorphs("fileable");
            $table->string('original_name', 255);
            $table->string('file_path', 255);
            $table->string('mime_type', 50);
            $table->integer('size');
            $table->enum('usage', ['avatar', 'attachment', 'source', 'figma', 'cv', 'other'])->default('other');
            $table->enum('visibility', ['public', 'private'])->default('private');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
