<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MedicalFilesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function index()
    {
        $data = $this->reportService->adminDashboard();
        return view('admin.reports', $data);
    }

    public function pdf()
    {
        $data = $this->reportService->adminDashboard();

        return Pdf::loadView('admin.reports_pdf', $data)
            ->setPaper('a4')
            ->download('admin_reports.pdf');
    }

    public function exportMedicalFiles()
    {
        return Excel::download(
            new MedicalFilesExport,
            'medical_files.xlsx'
        );
    }
}
