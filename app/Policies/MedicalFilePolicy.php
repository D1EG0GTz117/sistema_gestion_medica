<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MedicalFile;

class MedicalFilePolicy
{
    public function view(User $user, MedicalFile $file): bool
    {
        return $user->hasRole('administrador')
            || $file->patient_id === $user->id
            || $file->doctor_id === $user->id;
    }

    public function upload(User $user): bool
    {
        return $user->hasAnyRole(['medico', 'administrador']);
    }

    public function download(User $user, MedicalFile $file): bool
    {
        return $this->view($user, $file);
    }
}
