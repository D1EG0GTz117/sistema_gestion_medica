@extends('layouts.sidenav')

@section('title', 'Facturación')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endpush

@section('content')

<h1 class="page-title">Facturación</h1>

<div class="payments-card">

    <div class="payments-card-header">
        Listado de Facturas
    </div>

    <table class="payments-table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Paciente</th>
                <th>Correo</th>
                <th>Médico</th>
                <th>Total</th>
                <th>Estado</th>
                <th>PDF</th>
            </tr>
        </thead>

        <tbody>
            @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->folio }}</td>

                <td>
                    {{ $invoice->patient?->name ?? '—' }}
                </td>

                <td>
                    {{ $invoice->patient?->email ?? '—' }}
                </td>

                <td>
                    {{ $invoice->doctor?->name ?? '—' }}
                </td>

                <td>
                    ${{ number_format($invoice->total, 2) }}
                </td>

                <td>
                    <span class="status status-{{ $invoice->status }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </td>

                <td data-label="Acciones">
                    <a href="{{ route('invoice.download', $invoice) }}"
                        class="btn-download">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-payments">
                    No hay facturas registradas
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $invoices->links() }}
    </div>

</div>

@endsection