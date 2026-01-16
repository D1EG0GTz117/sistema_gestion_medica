@extends('layouts.sidenav')

@section('title', 'Expedientes Médicos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/records.css') }}">
@endpush

@section('content')

<h1 class="page-title">Expedientes Médicos</h1>

<div class="records-card">

    <div class="records-card-header">
        Subir nuevo expediente
    </div>

    <form method="POST"
        action="{{ route('records.store') }}"
        enctype="multipart/form-data"
        class="records-form">
        @csrf

        <div class="form-group">
            <label>Paciente</label>
            <select name="patient_id" required>
                <option value="">Seleccione un paciente</option>
                @foreach($patients as $patient)
                <option value="{{ $patient->id }}">
                    {{ $patient->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Título</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Archivo</label>
            <input type="file" name="file" required>
        </div>

        <button type="submit" class="btn-primary">
            Subir archivo
        </button>

    </form>

</div>

<div class="records-card">

    <div class="records-card-header">
        Listado de expedientes
    </div>

    <table class="records-table">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{ $record->patient->name }}</td>
                <td>{{ $record->title }}</td>
                <td>{{ $record->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('records.download', $record) }}"
                        class="btn-primary small">
                        Descargar
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-records">
                    No hay expedientes registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $records->links() }}
    </div>

</div>

@endsection