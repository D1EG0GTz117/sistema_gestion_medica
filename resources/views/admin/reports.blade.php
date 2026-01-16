@extends('layouts.sidenav')

@section('title', 'Reportes Administrativos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')

<h1 class="page-title">Reportes Administrativos</h1>

<div class="reports-card">

    <div class="reports-card-header">
        Resumen General
    </div>

    <div class="reports-card-body">

        <ul class="reports-stats">
            <li>
                <span>Pacientes</span>
                <strong>{{ $stats['total_patients'] }}</strong>
            </li>
            <li>
                <span>Médicos</span>
                <strong>{{ $stats['total_doctors'] }}</strong>
            </li>
            <li>
                <span>Archivos</span>
                <strong>{{ $stats['total_files'] }}</strong>
            </li>
            <li>
                <span>Ingresos</span>
                <strong>${{ number_format($stats['total_income'], 2) }}</strong>
            </li>
        </ul>

        <div class="reports-actions">
            <a href="{{ route('reports.export.medical-files') }}" class="btn-generate">
                Exportar Archivos (Excel)
            </a>

            <a href="{{ route('reports.pdf') }}" class="btn-generate secondary">
                Descargar PDF
            </a>
        </div>

    </div>

</div>

@endsection