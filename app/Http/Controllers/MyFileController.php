<?php

namespace App\Http\Controllers;

use App\Models\MedicalFile;
use Barryvdh\DomPDF\Facade\Pdf;

class MyFileController extends Controller
{
    /**
     * Listado de archivos médicos
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $files = MedicalFile::with(['doctor', 'patient'])
                ->latest()
                ->paginate(20);
        } else {
            $files = MedicalFile::with(['doctor'])
                ->where('patient_id', $user->id)
                ->latest()
                ->paginate(20);
        }

        return view('paciente.my_files', compact('files'));
    }

    public function download(MedicalFile $medicalFile)
    {
        $this->authorize('view', $medicalFile);

        $medicalFile->load(['doctor', 'patient', 'records']);

        $pdf = Pdf::loadView('paciente.medical_file_pdf', compact('medicalFile'))
            ->setPaper('a4');

        return $pdf->download('Expediente_' . $medicalFile->id . '.pdf');
    }
}
