<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $invoice->folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            margin: auto;
            width: 90%;
            max-width: 800px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 1.8em;
            margin: 0;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-details th {
            text-align: left;
            width: 30%;
            padding: 5px;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f2f2f2;
            font-weight: bold;
            border-radius: 5px;
        }

        .status.pagada {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Factura: {{ $invoice->folio }}</h1>
            <p>Emitida el: {{ $invoice->issue_date->format('d/m/Y') }}</p>
        </div>

        <table class="invoice-details">
            <tr>
                <th>Paciente:</th>
                <td>{{ $invoice->patient->name }}</td>
            </tr>
            <tr>
                <th>Correo:</th>
                <td>{{ $invoice->patient->email }}</td>
            </tr>
            <tr>
                <th>Médico:</th>
                <td>{{ $invoice->doctor->name }}</td>
            </tr>
            <tr>
                <th>Concepto:</th>
                <td>{{ $invoice->concept }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td>${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td><span class="status {{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span></td>
            </tr>
        </table>

        <div class="total">
            <p><strong>Total: </strong>${{ number_format($invoice->total, 2) }}</p>
        </div>
    </div>
</body>

</html>