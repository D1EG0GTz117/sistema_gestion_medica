@extends('layouts.sidenav')

@section('title', 'Dashboard Administrativo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<h1 class="page-title">Panel Médico</h1>

<div class="users-card">

    <div class="dashboard-grid">
        <div class="dashboard-item">
            <h3>Pacientes</h3>
            <p>Listado de pacientes asignados</p>
            <a href="{{ route('patients') }}" class="btn-primary">Ver pacientes</a>
        </div>

        <div class="dashboard-item">
            <h3>Expedientes</h3>
            <p>Historial clínico y archivos</p>
            <a href="{{ route('records') }}" class="btn-primary">Ver expedientes</a>
        </div>

        <div class="dashboard-item">
            <h3>Facturación</h3>
            <p>Facturas generadas</p>
            <a href="{{ route('invoice') }}" class="btn-primary">Ver facturas</a>
        </div>

        <div class="dashboard-item">
            <h3>Pagos</h3>
            <p>Pagos registrados</p>
            <a href="{{ route('payments') }}" class="btn-primary">Ver pagos</a>
        </div>
    </div>
</div>

@endsection