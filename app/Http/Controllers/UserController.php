<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('admin.users', compact('users', 'search'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.createuser', compact('roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();


        return view('admin.editusers', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'date_of_birth'  => $request->date_of_birth,
            'rfc'            => $request->rfc,
            'business_name'  => $request->business_name,
            'fiscal_address' => $request->fiscal_address,
        ]);

        $user->syncRoles([$request->role]);

        if ($request->role === 'medico') {
            $user->medicalProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'cedula'       => $request->cedula,
                    'especialidad' => $request->especialidad,
                ]
            );
        }

        return redirect()
            ->route('users')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function toggle(User $user)
    {
        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back()->with('success', 'Estado del usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
