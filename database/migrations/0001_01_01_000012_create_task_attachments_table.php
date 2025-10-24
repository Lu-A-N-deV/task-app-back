<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->uuid('uploaded_by');
            $table->text('filepath');
            $table->timestampsTz();
            $table->softDeletesTz();

            // Foreign keys
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_attachments');
    }
};
