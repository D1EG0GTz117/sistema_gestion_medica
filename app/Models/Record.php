<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'medical_file_id', // o el campo que se usa como clave foránea
        'title',
        'description',
        // Otros campos que tenga el registro
    ];

    // Relación con el archivo médico
    public function medicalFile()
    {
        return $this->belongsTo(MedicalFile::class, 'medical_file_id');
    }
}
