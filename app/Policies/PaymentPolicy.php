<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;

class PaymentPolicy
{
    public function pay(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('paciente')
            && $invoice->patient_id === $user->id
            && $invoice->status === 'pendiente';
    }

    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('paciente')
            && $invoice->patient_id === $user->id;
    }
}
