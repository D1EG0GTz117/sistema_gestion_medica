@extends('layouts.sidenav')

@section('title', 'Dashboard Administrativo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<h1 class="page-title">Panel Administrativo</h1>

<div class="users-card">

    <div class="dashboard-grid">
        <div class="dashboard-item">
            <h3>Usuarios</h3>
            <p>Administración de médicos y pacientes</p>
            <a href="{{ route('users') }}" class="btn-primary">Gestionar</a>
        </div>

        <div class="dashboard-item">
            <h3>Archivos Médicos</h3>
            <p>Documentos clínicos del sistema</p>
            <a href="{{ route('files') }}" class="btn-primary">Ver archivos</a>
        </div>

        <div class="dashboard-item">
            <h3>Reportes</h3>
            <p>Exportación PDF y Excel</p>
            <a href="{{ route('reports') }}" class="btn-primary">Ver reportes</a>
        </div>
    </div>
</div>

@endsection