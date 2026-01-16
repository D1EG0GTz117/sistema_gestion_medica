@extends('layouts.sidenav')

@section('title', 'Mis Facturas')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/myinvoices.css') }}">
@endpush

@section('content')

<h1 class="page-title">Mis Facturas</h1>

<div class="my-invoices-card">

    <div class="my-invoices-card-header">
        Historial de Facturas
    </div>

    <table class="my-invoices-table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Médico</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->folio }}</td>

                <td>
                    {{ $invoice->doctor->name ?? '—' }}
                </td>

                <td>
                    ${{ number_format($invoice->total, 2) }}
                </td>

                <td>
                    <span class="status status-{{ $invoice->status }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('my_invoices.download', $invoice->id) }}"
                        class="btn-download">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-invoices">
                    No tienes facturas registradas
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