@extends('layouts.sidenav')

@section('title', 'Usuarios')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4">

    <h1 class="page-title">Gestión de Usuarios</h1>

    <div class="users-card">

        <div class="users-card-header">
            Usuarios registrados
        </div>

        <form action="{{ route('users') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Buscar por nombre o correo">
            <button class="btn-primary">Buscar</button>
        </form>

        <div class="users-table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td data-label="Nombre">{{ $user->name }}</td>
                        <td data-label="Email">{{ $user->email }}</td>

                        <td data-label="Rol">
                            @forelse($user->roles as $role)
                            <span class="role-badge">{{ ucfirst($role->name) }}</span>
                            @empty
                            <span class="role-badge role-empty">Sin rol</span>
                            @endforelse
                        </td>

                        <td data-label="Activo">
                            <form action="{{ route('users.toggle', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="switch">
                                    <input type="checkbox"
                                        onchange="this.form.submit()"
                                        {{ $user->is_active ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </form>
                        </td>

                        <td data-label="Acciones">
                            <div class="actions">
                                <a href="{{ route('users.edit', $user) }}" class="btn-edit">
                                    Editar
                                </a>

                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="no-users">
                            No hay usuarios registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-container">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#0d6efd'
            }).then(r => r.isConfirmed && form.submit());
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Correcto',
        confirmButtonText: 'Aceptar',
        text: "{{ session('success') }}",
        confirmButtonColor: '#0d6efd'
    });
</script>
@endif
@endsection