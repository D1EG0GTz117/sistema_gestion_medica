<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\MedicalFile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

class InvoiceController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => User::role('paciente')->count(),
            'total_doctors'  => User::role('medico')->count(),
            'total_files'    => MedicalFile::count(),
            'total_income'   => Transaction::where('status', 'pagado')->sum('amount'),
        ];

        return view('admin.reports', compact('stats'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $invoice->load(['patient', 'doctor', 'details']);

        $pdf = Pdf::loadView('admin.reports_pdf', compact('invoice'))
            ->setPaper('a4');

        return $pdf->download('Factura_' . $invoice->folio . '.pdf');
    }
}
