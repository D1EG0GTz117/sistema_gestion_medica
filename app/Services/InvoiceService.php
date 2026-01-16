<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function create(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {

            $subtotal = collect($data['items'])->sum(
                fn($item) => $item['quantity'] * $item['unit_price']
            );

            $tax = $subtotal * 0.16;
            $total = $subtotal + $tax;

            $invoice = Invoice::create([
                'patient_id'       => $data['patient_id'],
                'doctor_id'        => auth()->id(),
                'folio'            => uniqid('FAC-'),
                'invoice_number'   => Invoice::max('invoice_number') + 1,
                'receiver_name'    => auth()->user()->name,
                'receiver_email'   => auth()->user()->email,
                'issuer_name'      => config('app.name'),
                'issuer_rfc'       => 'AAA010101AAA',
                'issuer_address'  => 'México',
                'subtotal'         => $subtotal,
                'tax_rate'         => 0.16,
                'tax_amount'       => $tax,
                'total'            => $total,
                'concept'          => $data['concept'],
                'status'           => 'pendiente',
                'issue_date'       => now(),
                'due_date'         => now()->addDays(7),
            ]);

            foreach ($data['items'] as $item) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'concept'    => $item['concept'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal'   => $item['quantity'] * $item['unit_price'],
                ]);
            }

            return $invoice;
        });
    }
}
