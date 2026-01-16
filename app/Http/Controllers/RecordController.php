<?php

namespace App\Http\Controllers;

use App\Models\MedicalFile;
use App\Services\EncryptionService;
use App\Http\Requests\Medico\StoreMedicalFileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

class RecordController extends Controller
{
    public function index()
    {
        $records = MedicalFile::with('patient')
            ->where('doctor_id', auth()->id())
            ->latest()
            ->paginate(10);

        $patients = \App\Models\User::role('paciente')->get();

        return view('medico.records', compact('records', 'patients'));
    }

    public function store(StoreMedicalFileRequest $request)
    {
        $file = $request->file('file');

        $content = file_get_contents($file->getRealPath());

        $encrypted = app(EncryptionService::class)->encrypt($content);

        $path = 'medical_files/' . now()->format('Y/m');
        $storedName = Str::uuid() . '.enc';

        $stored = Storage::put($path . '/' . $storedName, $encrypted);

        if (!$stored) {
            return back()->withErrors('No se pudo guardar el archivo');
        }

        MedicalFile::create([
            'patient_id'     => $request->patient_id,
            'doctor_id'      => auth()->id(),
            'category_id'    => null,
            'title'          => $request->title,
            'description'    => null,

            'original_name'  => $file->getClientOriginalName(),
            'stored_name'    => $storedName,
            'file_path'      => $path . '/' . $storedName,
            'file_size'      => $file->getSize(),
            'mime_type'      => $file->getClientMimeType(),
            'file_extension' => $file->getClientOriginalExtension(),

            'is_encrypted'   => true,
            'encryption_key' => null,
            'version'        => 1,
            'parent_file_id' => null,
            'study_date'     => now(),
            'notes'          => null,
            'is_active'      => true,
        ]);

        return redirect()
            ->route('records')
            ->with('success', 'Archivo subido correctamente');
    }

    public function download(MedicalFile $file)
    {
        $this->authorize('download', $file);

        $encrypted = Storage::get($file->file_path);
        $content = app(EncryptionService::class)->decrypt($encrypted);

        return response($content)
            ->header('Content-Type', $file->mime_type)
            ->header(
                'Content-Disposition',
                'attachment; filename="' . $file->original_name . '"'
            );
    }
}
