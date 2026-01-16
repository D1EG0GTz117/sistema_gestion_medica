<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
            'is_active' => 1,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard.admin');
            }

            if ($user->hasRole('medico')) {
                return redirect()->route('dashboard.medico');
            }

            if ($user->hasRole('paciente')) {
                return redirect()->route('dashboard.paciente');
            }

            if (! $user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
                ]);
            }


            Auth::logout();
            abort(403);
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas o usuario inactivo',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
