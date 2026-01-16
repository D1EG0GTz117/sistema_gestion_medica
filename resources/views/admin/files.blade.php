@extends('layouts.sidenav')

@section('title', 'Mis Archivos Médicos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/files.css') }}">
@endpush

@section('content')

<h1 class="page-title">Archivos Médicos</h1>

<div class="files-card">

    <div class="files-card-header">
        Resumen de Archivos
    </div>

    <div class="files-card-body">
        <form method="POST" action="{{ route('files.zip') }}">
            @csrf

            <table class="files-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Categoría</th>
                        <th>Título</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($files as $file)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_files[]" value="{{ $file->id }}">
                        </td>

                        <td>
                            <span class="file-badge">
                                {{ $file->category?->name ?? 'N/A' }}
                            </span>
                        </td>

                        <td>{{ $file->title }}</td>

                        <td>
                            <span class="file-badge file-badge-secondary">
                                {{ $file->doctor?->name ?? '-' }}
                            </span>
                        </td>

                        <td>{{ $file->created_at->format('Y-m-d') }}</td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('files.download', $file) }}" class="btn-download">
                                    Descargar
                                </a>

                                @if($file->versions()->count() > 0)
                                <a href="{{ route('files.versions', $file) }}" class="btn-download">
                                    Versiones
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-files">
                            No tienes archivos médicos.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($files->count())
            <button type="submit" class="btn-zip">
                Descargar selección (ZIP)
            </button>
            @endif
        </form>
    </div>
</div>

<div class="pagination-container">
    {{ $files->links() }}
</div>

@endsection