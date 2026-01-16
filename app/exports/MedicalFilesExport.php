<?php

namespace App\Exports;

use App\Models\MedicalFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicalFilesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MedicalFile::with(['patient', 'doctor'])
            ->get()
            ->map(function ($file) {
                return [
                    'ID'       => $file->id,
                    'Paciente' => $file->patient->name,
                    'Médico'   => $file->doctor->name,
                    'Título'   => $file->title,
                    'Fecha'    => $file->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Paciente',
            'Médico',
            'Título',
            'Fecha'
        ];
    }
}
