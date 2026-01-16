@extends('layouts.sidenav')

@section('title', 'Mis Archivos Médicos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/myfiles.css') }}">
@endpush

@section('content')

@php
$patient = auth()->user();
@endphp

<h1 class="page-title">Mis Archivos Médicos</h1>

<div class="files-card">

    <div class="files-card-header">
        {{ $patient->name }} 
    </div>

    <div class="files-card-body">

        <table class="files-table">
            <thead>
                <tr>
                    <th>Archivo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($files as $file)
                <tr>
                    <td>
                        {{ $file->name }}
                    </td>

                    <td>
                        {{ $file->description ?? 'Sin descripción' }}
                    </td>

                    <td>
                        {{ $file->created_at->format('Y-m-d') }}
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('my_files.download', $file->id) }}"
                                class="btn-download">
                                <i class="fa-solid fa-file-download"></i> Descargar
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="no-files">
                        No tienes archivos médicos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $files->links() }}
        </div>

    </div>
</div>

@endsection