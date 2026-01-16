<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Transaction::with(['paymentMethod', 'invoice.doctor'])
            ->whereHas('invoice', function ($q) {
                $q->where('patient_id', Auth::id());
            });

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $payments->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%$search%")
                    ->orWhereHas('invoice.doctor', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        $payments = $payments->latest()->paginate(20);

        return view('paciente.my_payments', compact('payments'));
    }
}
