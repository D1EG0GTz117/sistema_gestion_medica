<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Solo los admin pueden ver todos los pagos
            $payments = Transaction::with(['patient', 'paymentMethod'])
                ->latest()
                ->paginate(20);
        } else {
            // Los demás roles no tienen acceso a esta información
            return redirect()->back()->with('error', 'No tienes permiso para ver los pagos');
        }

        return view('medico.payments', compact('payments'));
    }
}
