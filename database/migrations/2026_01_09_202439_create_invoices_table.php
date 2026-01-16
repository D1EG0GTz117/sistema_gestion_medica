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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();

            $table->string('folio', 20)->unique();
            $table->string('series', 10)->default('A');
            $table->integer('invoice_number');

            $table->string('receiver_name', 255);
            $table->string('receiver_rfc', 13)->nullable();
            $table->string('receiver_email', 255);
            $table->text('receiver_address')->nullable();

            $table->string('issuer_name', 255);
            $table->string('issuer_rfc', 13);
            $table->text('issuer_address');

            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_rate', 5, 4)->default(0.1600);
            $table->decimal('tax_amount', 12, 2);
            $table->decimal('total', 12, 2);

            $table->text('concept');
            $table->text('notes')->nullable();

            $table->string('payment_method', 50)->default('Tarjeta de crédito');
            $table->string('payment_terms', 100)->default('Pago inmediato');

            $table->enum('status', ['pendiente', 'pagada', 'vencida', 'cancelada'])
                ->default('pendiente');

            $table->timestamp('issue_date');
            $table->timestamp('due_date');
            $table->timestamp('paid_date')->nullable();

            $table->string('pdf_path', 500)->nullable();
            $table->string('xml_path', 500)->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('patient_id', 'idx_invoices_patient');
            $table->index('doctor_id', 'idx_invoices_doctor');
            $table->index('folio', 'idx_invoices_folio');
            $table->index('status', 'idx_invoices_status');
            $table->index(['issue_date', 'due_date'], 'idx_invoices_dates');
            $table->index(['series', 'invoice_number'], 'idx_invoices_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
