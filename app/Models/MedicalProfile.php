<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalProfile extends Model
{
    protected $fillable = [
        'user_id',
        'medical_license',
        'specialty',
        'clinic_name',
        'clinic_address',
        'consultation_fee',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
