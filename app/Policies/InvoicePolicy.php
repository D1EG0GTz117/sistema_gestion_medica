<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('medico')) {
            return $invoice->doctor_id === $user->id;
        }

        if ($user->hasRole('paciente')) {
            return $invoice->patient_id === $user->id;
        }

        return false;
    }
}
