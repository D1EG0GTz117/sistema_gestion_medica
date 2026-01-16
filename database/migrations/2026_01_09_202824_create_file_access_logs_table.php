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
        Schema::create('file_access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_file_id');
            $table->unsignedBigInteger('user_id');

            $table->enum('action', [
                'view',
                'download',
                'upload',
                'delete',
                'share'
            ]);

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('medical_file_id')
                ->references('id')
                ->on('medical_files')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('medical_file_id', 'idx_file_access_file');
            $table->index('user_id', 'idx_file_access_user');
            $table->index('action', 'idx_file_access_action');
            $table->index('created_at', 'idx_file_access_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_access_logs');
    }
};
