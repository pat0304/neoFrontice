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
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreign("id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger('admin_role_id');
            $table->foreign('admin_role_id')->references('id')->on('admin_roles')->onDelete('cascade');
            $table->enum('access_level', [1, 2, 3, 4])->default(4);
            // level 1: super admin
            // level 2: admin
            // level 3: moderator
            // level 4: support
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
