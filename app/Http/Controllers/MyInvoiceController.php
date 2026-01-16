<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class MyInvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $invoices = Invoice::with(['doctor', 'patient'])->latest()->paginate(20);
        } else {
            $invoices = Invoice::with(['doctor'])
                ->where('patient_id', $user->id)
                ->latest()
                ->paginate(20);
        }

        return view('paciente.my_invoices', compact('invoices'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $invoice->load(['doctor', 'patient', 'details']);

        $pdf = Pdf::loadView('paciente.invoice_pdf', compact('invoice'))
            ->setPaper('a4');

        return $pdf->download('Factura_' . $invoice->folio . '.pdf');
    }
}
