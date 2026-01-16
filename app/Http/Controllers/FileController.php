<?php

namespace App\Http\Controllers;

use App\Models\MedicalFile;
use App\Models\FileAccessLog;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileController extends Controller
{
    public function index()
    {
        // ADMIN
        if (auth()->user()->hasRole('admin')) {
            $files = MedicalFile::with(['patient', 'category'])
                ->latest()
                ->paginate(20);

            return view('admin.files', compact('files'));
        }

        $files = MedicalFile::with(['category', 'doctor'])
            ->where('patient_id', auth()->id())
            ->where('is_active', true)
            ->latest()
            ->paginate(20);

        return view('paciente.my_files', compact('files'));
    }

    public function download(MedicalFile $medicalFile)
    {
        if (
            auth()->user()->hasRole('paciente') &&
            $medicalFile->patient_id !== auth()->id()
        ) {
            abort(403);
        }

        FileAccessLog::create([
            'medical_file_id' => $medicalFile->id,
            'user_id'         => auth()->id(),
            'action'          => 'download',
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
        ]);


        $encrypted = Storage::get($medicalFile->file_path);
        $content   = app(EncryptionService::class)->decrypt($encrypted);

        return response($content)
            ->header('Content-Type', $medicalFile->mime_type)
            ->header(
                'Content-Disposition',
                'attachment; filename="' . $medicalFile->original_name . '"'
            );
    }

    public function versions(MedicalFile $medicalFile)
    {
        if (
            auth()->user()->hasRole('paciente') &&
            $medicalFile->patient_id !== auth()->id()
        ) {
            abort(403);
        }

        $versions = $medicalFile->versions()
            ->latest()
            ->get();

        return view('paciente.file_versions', compact('medicalFile', 'versions'));
    }

    public function downloadZip(Request $request)
    {
        $request->validate([
            'selected_files' => 'required|array|min:1',
            'selected_files.*' => 'integer'
        ]);

        $user = auth()->user();

        $query = MedicalFile::whereIn('id', $request->selected_files)
            ->where('is_active', true);

        if ($user->hasRole('paciente')) {
            $query->where('patient_id', $user->id);
        }

        if ($user->hasRole('medico')) {
            $query->where('doctor_id', $user->id);
        }

        $files = $query->get();

        if ($files->isEmpty()) {
            return back()->with('error', 'No se encontraron archivos válidos');
        }

        $zipName = 'mis_archivos_' . time() . '.zip';
        $zipPath = storage_path('app/' . $zipName);

        $zip = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($files as $file) {
            $encrypted = Storage::get($file->file_path);
            $content = app(EncryptionService::class)->decrypt($encrypted);

            $zip->addFromString($file->original_name, $content);

            \App\Models\FileAccessLog::create([
                'medical_file_id' => $file->id,
                'user_id' => $user->id,
                'action' => 'download',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
