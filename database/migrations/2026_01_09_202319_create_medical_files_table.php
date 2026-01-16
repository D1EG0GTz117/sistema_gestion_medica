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
        Schema::create('medical_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('parent_file_id')->nullable();


            $table->string('original_name', 255);
            $table->string('stored_name', 255);
            $table->string('file_path', 500);
            $table->unsignedBigInteger('file_size');
            $table->string('mime_type', 100);
            $table->string('file_extension', 10);


            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('study_date')->nullable();
            $table->text('notes')->nullable();


            $table->integer('version')->default(1);
            $table->boolean('is_encrypted')->default(true);
            $table->string('encryption_key', 255)->nullable();


            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('category_id')
                ->references('id')
                ->on('medical_file_categories');

            $table->foreign('parent_file_id')
                ->references('id')
                ->on('medical_files')
                ->onDelete('set null');

            $table->index('patient_id', 'idx_medical_files_patient');
            $table->index('doctor_id', 'idx_medical_files_doctor');
            $table->index('category_id', 'idx_medical_files_category');
            $table->index('study_date', 'idx_medical_files_date');
            $table->index('created_at', 'idx_medical_files_created');

            $table->fullText(
                ['title', 'description', 'notes'],
                'ft_medical_files_search'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_files');
    }
};
