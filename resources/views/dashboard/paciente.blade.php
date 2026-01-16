@extends('layouts.sidenav')

@section('title', 'Dashboard del Paciente')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<h1 class="page-title">Panel del Paciente</h1>

<div class="users-card">

    <div class="dashboard-grid">
        <div class="dashboard-item">
            <h3>Mis Archivos</h3>
            <p>Documentos médicos personales</p>
            <a href="{{ route('my_files') }}" class="btn-primary">Ver archivos</a>
        </div>

        <div class="dashboard-item">
            <h3>Mis Facturas</h3>
            <p>Historial de facturación</p>
            <a href="{{ route('my_invoices') }}" class="btn-primary">Ver facturas</a>
        </div>

        <div class="dashboard-item">
            <h3>Mis Pagos</h3>
            <p>Pagos realizados</p>
            <a href="{{ route('my_payments') }}" class="btn-primary">Ver pagos</a>
        </div>
    </div>
</div>

@endsection