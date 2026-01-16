@extends('layouts.sidenav')

@section('title', 'Mis Pagos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/mypayments.css') }}">
@endpush

@section('content')

<h1 class="page-title">Mis Pagos</h1>

<div class="payments-card">

    <div class="payments-card-header">
        Historial de Pagos
    </div>

    <table class="payments-table">
        <thead>
            <tr>
                <th>Factura</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>
                    {{ $payment->invoice?->folio ?? 'N/A' }}
                </td>

                <td>
                    ${{ number_format($payment->amount, 2) }}
                </td>

                <td>
                    <span class="status {{ $payment->status }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>

                <td>
                    {{ optional($payment->processed_at)->format('d/m/Y') ?? '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-payments">
                    No tienes pagos registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $payments->links() }}
    </div>

</div>

@endsection