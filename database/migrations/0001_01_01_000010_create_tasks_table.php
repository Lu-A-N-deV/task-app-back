<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('task_type_id');
            $table->unsignedBigInteger('task_priority_id');
            $table->unsignedBigInteger('task_status_id');
            $table->uuid('created_by');
            $table->uuid('assigned_to')->nullable();
            $table->timestampTz('due_date')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            // Foreign keys
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('task_type_id')->references('id')->on('task_types');
            $table->foreign('task_priority_id')->references('id')->on('task_priorities');
            $table->foreign('task_status_id')->references('id')->on('task_statuses');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
