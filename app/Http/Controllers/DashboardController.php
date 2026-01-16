<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        return match (true) {
            $user->hasRole('admin') => view('dashboard.admin'),
            $user->hasRole('medico')        => view('dashboard.medico'),
            $user->hasRole('paciente')      => view('dashboard.paciente'),
            default                         => abort(403),
        };
    }
}
