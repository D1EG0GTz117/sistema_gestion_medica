<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public function process(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {

            $invoice = Invoice::lockForUpdate()->findOrFail($data['invoice_id']);

            $transaction = Transaction::create([
                'invoice_id'       => $invoice->id,
                'patient_id'       => auth()->id(),
                'payment_method_id' => $data['payment_method_id'],
                'transaction_id'   => Str::uuid(),
                'amount'           => $invoice->total,
                'net_amount'       => $invoice->total,
                'currency'         => 'MXN',
                'status'           => 'completada',
                'processed_at'     => now(),
                'description'      => 'Pago de factura ' . $invoice->folio,
            ]);

            $invoice->update([
                'status'    => 'pagada',
                'paid_date' => now(),
            ]);

            return $transaction;
        });
    }
}
