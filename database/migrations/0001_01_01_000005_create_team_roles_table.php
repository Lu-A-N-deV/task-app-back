<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->string('key');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            // Foreign keys
            $table->unique(['team_id', 'name']);
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_roles');
    }
};
