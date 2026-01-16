@extends('layouts.sidenav')

@section('title', 'Pacientes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/patients.css') }}">
@endpush

@section('content')

<h1 class="page-title">Pacientes</h1>

<div class="reports-card">

    <div class="reports-card-header">
        Listado de Pacientes
    </div>

    <div class="reports-card-body">

        <table class="patients-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>RFC</th>
                    <th>Razón Social</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->rfc ?? 'N/A' }}</td>
                    <td>{{ $patient->business_name ?? 'N/A' }}</td>
                    <td>
                        @if($patient->is_active)
                        <span class="status active">Activo</span>
                        @else
                        <span class="status inactive">Inactivo</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data">
                        No hay pacientes registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $patients->links() }}
        </div>

    </div>

</div>

@endsection