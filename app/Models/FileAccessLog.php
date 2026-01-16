<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_file_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'details',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class, 'medical_file_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
