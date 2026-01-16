@extends('layouts.sidenav')

@section('title', 'Editar Usuario')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/editusers.css') }}">
@endpush

@section('content')

<div class="container px-4">
    <h1 class="page-title">Editar Usuario</h1>

    <div class="users-card">
        <div class="users-card-header">
            Información del usuario
        </div>

        <form id="editUserForm" action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h4>Datos personales</h4>

                <div class="form-grid">
                    <div>
                        <label>Nombre <span class="req">*</span></label>
                        <input type="text" name="name" class="required"
                            value="{{ old('name', $user->name) }}">
                    </div>

                    <div>
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email" class="required"
                            value="{{ old('email', $user->email) }}">
                    </div>

                    <div>
                        <label>Teléfono</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div>
                        <label>Fecha de nacimiento</label>
                        <input type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4>Datos fiscales</h4>

                <div class="form-grid">
                    <div>
                        <label>RFC</label>
                        <input type="text" name="rfc"
                            value="{{ old('rfc', $user->rfc) }}">
                    </div>

                    <div>
                        <label>Razón social</label>
                        <input type="text" name="business_name"
                            value="{{ old('business_name', $user->business_name) }}">
                    </div>

                    <div class="full">
                        <label>Dirección fiscal</label>
                        <textarea name="fiscal_address" rows="2">{{ old('fiscal_address', $user->fiscal_address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ROL --}}
            <div class="form-section">
                <h4>Rol del usuario <span class="req">*</span></h4>

                <select name="role" id="role-select" class="required">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->roles->first()?->name === $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-section" id="medical-fields">
                <h4>Datos médicos</h4>

                <div class="form-grid">
                    <div>
                        <label>Cédula profesional <span class="req">*</span></label>
                        <input type="text" name="cedula" class="medico-required"
                            value="{{ old('cedula', $user->medicalProfile->cedula ?? '') }}">
                    </div>

                    <div>
                        <label>Especialidad <span class="req">*</span></label>
                        <input type="text" name="especialidad" class="medico-required"
                            value="{{ old('especialidad', $user->medicalProfile->especialidad ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Guardar cambios</button>
                <a href="{{ route('users') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>



</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const roleSelect = document.getElementById('role-select');
        const medicalFields = document.getElementById('medical-fields');
        const form = document.getElementById('editUserForm');

        const toggleMedical = () => {
            medicalFields.style.display = roleSelect.value === 'medico' ? 'block' : 'none';
        };

        roleSelect.addEventListener('change', toggleMedical);
        toggleMedical();

        form.addEventListener('submit', e => {
            let valid = true;

            document.querySelectorAll('.required').forEach(input => {
                if (!input.value.trim()) valid = false;
            });

            if (roleSelect.value === 'medico') {
                document.querySelectorAll('.medico-required').forEach(input => {
                    if (!input.value.trim()) valid = false;
                });
            }

            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos obligatorios',
                    text: 'Por favor completa todos los campos requeridos.',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Usuario actualizado',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2563eb'
    }).then(() => {
        window.location.href = "{{ route('users') }}";
    });
</script>
@endif
@endsection