<?php

namespace App\Services;

use App\Models\User;
use App\Models\MedicalFile;
use App\Models\Invoice;

class ReportService
{
    /**
     * Datos para dashboard admin
     */
    public function adminDashboard(): array
    {
        return [
            'stats' => [
                'total_patients' => User::role('paciente')->count(),
                'total_doctors'  => User::role('medico')->count(),
                'total_files'    => MedicalFile::count(),
                'total_income'   => Invoice::where('status', 'paid')->sum('total'),
            ],
            'files' => MedicalFile::with(['patient', 'doctor'])
                ->latest()
                ->take(100)
                ->get(),
        ];
    }
}
