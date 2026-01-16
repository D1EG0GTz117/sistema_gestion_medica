<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'rfc',
        'business_name',
        'fiscal_address',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function medicalProfile()
    {
        return $this->hasOne(MedicalProfile::class);
    }

    public function medicalFilesAsDoctor()
    {
        return $this->hasMany(MedicalFile::class, 'doctor_id');
    }

    public function medicalFilesAsPatient()
    {
        return $this->hasMany(MedicalFile::class, 'patient_id');
    }

    public function invoicesAsDoctor()
    {
        return $this->hasMany(Invoice::class, 'doctor_id');
    }

    public function invoicesAsPatient()
    {
        return $this->hasMany(Invoice::class, 'patient_id');
    }

    public function payments()
    {
        return $this->hasMany(Transaction::class, 'patient_id');
    }
}
