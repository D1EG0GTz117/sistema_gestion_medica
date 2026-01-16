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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('payment_method_id');

            $table->string('transaction_id', 100)->unique();
            $table->string('external_id', 100)->nullable();

            $table->decimal('amount', 12, 2);
            $table->decimal('fee', 10, 2)->default(0.00);
            $table->decimal('net_amount', 12, 2);

            $table->string('currency', 3)->default('MXN');
            $table->enum('status', ['pendiente', 'completada', 'fallida', 'cancelada', 'reembolsada'])->default('pendiente');

            $table->string('gateway_status', 50)->nullable();

            $table->text('description')->nullable();
            $table->string('reference', 100)->nullable();
            $table->string('authorization_code', 50)->nullable();
            $table->json('gateway_response')->nullable();
            $table->text('failure_reason')->nullable();

            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('set null');

            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');

            $table->index('invoice_id', 'idx_transactions_invoice');
            $table->index('patient_id', 'idx_transactions_patient');
            $table->index('external_id', 'idx_transactions_external');
            $table->index('status', 'idx_transactions_status');
            $table->index('processed_at', 'idx_transactions_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
