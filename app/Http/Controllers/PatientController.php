<?php

namespace App\Http\Controllers;

use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::role('paciente')
            ->where('is_active', true)
            ->paginate(15);

        return view('medico.patients', compact('patients'));
    }

    public function show(User $patient)
    {
        $patient->load('roles');

        return view('medico.patient_show', compact('patient'));
    }
}
