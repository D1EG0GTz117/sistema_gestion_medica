<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MedicalFile extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'category_id',
        'original_name',
        'stored_name',
        'file_path',
        'file_size',
        'mime_type',
        'file_extension',
        'title',
        'description',
        'study_date',
        'notes',
        'version',
        'parent_file_id',
        'is_encrypted',
        'encryption_key',
        'is_active',
    ];

    protected $casts = [
        'study_date' => 'date',
        'is_encrypted' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function category()
    {
        return $this->belongsTo(MedicalFileCategory::class);
    }

    public function parent()
    {
        return $this->belongsTo(MedicalFile::class, 'parent_file_id');
    }

    public function versions()
    {
        return $this->hasMany(MedicalFile::class, 'parent_file_id');
    }

    public function logs()
    {
        return $this->hasMany(FileAccessLog::class);
    }

    // Relación con los registros
    public function records()
    {
        return $this->hasMany(Record::class, 'medical_file_id');  // Ajusta 'medical_file_id' con el nombre de la clave foránea en la tabla 'records'
    }
}
