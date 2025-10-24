<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->uuid('user_id');
            $table->unsignedBigInteger('team_role_id');
            $table->timestampsTz();
            $table->softDeletesTz();

            // Foreign keys
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_role_id')->references('id')->on('team_roles');
            $table->unique(['team_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_users');
    }
};
