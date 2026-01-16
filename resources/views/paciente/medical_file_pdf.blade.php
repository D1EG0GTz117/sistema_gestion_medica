<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Expediente Médico</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        .section {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h1>Expediente Médico</h1>

    <div class="section">
        <strong>Paciente:</strong> {{ $medicalFile->patient->name ?? '—' }} <br>
        <strong>Médico:</strong> {{ $medicalFile->doctor->name ?? '—' }}
    </div>

    <div class="section">
        <strong>Título:</strong> {{ $medicalFile->title }} <br>
        <strong>Descripción:</strong> {{ $medicalFile->description ?? '—' }}
    </div>

    <div class="section">
        <strong>Fecha del estudio:</strong> {{ optional($medicalFile->study_date)->format('d/m/Y') ?? '—' }}
    </div>

</body>

</html>