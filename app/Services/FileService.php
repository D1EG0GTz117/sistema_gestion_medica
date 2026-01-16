<?php

namespace App\Services;

use App\Models\MedicalFile;
use App\Models\FileAccessLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function __construct(
        protected EncryptionService $encryptionService
    ) {}

    public function store(array $data, UploadedFile $file): MedicalFile
    {
        $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "medical_files/{$data['patient_id']}";

        $content = file_get_contents($file->getRealPath());
        $encrypted = $this->encryptionService->encrypt($content);

        Storage::put("$path/$storedName", $encrypted);

        return MedicalFile::create([
            'patient_id'      => $data['patient_id'],
            'doctor_id'       => auth()->id(),
            'category_id'     => $data['category_id'],
            'original_name'   => $file->getClientOriginalName(),
            'stored_name'     => $storedName,
            'file_path'       => "$path/$storedName",
            'file_size'       => $file->getSize(),
            'mime_type'       => $file->getMimeType(),
            'file_extension'  => $file->getClientOriginalExtension(),
            'title'           => $data['title'],
            'description'     => $data['description'] ?? null,
            'study_date'      => $data['study_date'] ?? null,
            'is_encrypted'    => true,
        ]);
    }

    public function log(MedicalFile $file, string $action): void
    {
        FileAccessLog::create([
            'medical_file_id' => $file->id,
            'user_id'         => auth()->id(),
            'action'          => $action,
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
        ]);
    }
}
