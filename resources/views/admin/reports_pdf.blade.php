<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h2>Reporte Administrativo</h2>

<ul>
    <li>Total pacientes: {{ $stats['total_patients'] }}</li>
    <li>Total médicos: {{ $stats['total_doctors'] }}</li>
    <li>Total archivos: {{ $stats['total_files'] }}</li>
    <li>Ingresos totales: ${{ number_format($stats['total_income'], 2) }}</li>
</ul>

<h3>Últimos Archivos Médicos</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Título</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($files as $file)
        <tr>
            <td>{{ $file->id }}</td>
            <td>{{ $file->patient->name }}</td>
            <td>{{ $file->doctor->name }}</td>
            <td>{{ $file->title }}</td>
            <td>{{ $file->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
