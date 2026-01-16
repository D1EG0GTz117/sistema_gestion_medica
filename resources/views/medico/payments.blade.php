@extends('layouts.sidenav')

@section('title', 'Pagos de Pacientes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
@endpush

@section('content')

<h1 class="page-title">Pagos de Pacientes</h1>

<div class="payments-card">

    <div class="payments-card-header">
        Historial de Pagos
    </div>

    <table class="payments-table">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Método</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->patient?->name ?? '—' }}</td>
                <td>{{ $payment->paymentMethod?->name ?? '—' }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
                <td>{{ optional($payment->processed_at)->format('Y-m-d') ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-payments">
                    No hay pagos registrados
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