<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalFileCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function files()
    {
        return $this->hasMany(MedicalFile::class, 'category_id');
    }
}
