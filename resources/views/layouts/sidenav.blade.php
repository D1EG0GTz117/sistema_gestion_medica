<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'sidenav')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <header class="header">
        <div class="logo">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>Gestión Médica</span>
        </div>

        <div class="user">
            <i class="fa-solid fa-user-doctor"></i>
            <span>{{ auth()->user()->name }}</span>
            <small>{{ auth()->user()->role }}</small>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </header>

    <div class="layout">

        <aside class="sidebar">

            {{-- DASHBOARD --}}
            @role('admin')
            <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> <span>Inicio</span>
            </a>
            @endrole

            @role('medico')
            <a href="{{ route('dashboard.medico') }}" class="{{ request()->routeIs('dashboard.medico') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> <span>Inicio</span>
            </a>
            @endrole

            @role('paciente')
            <a href="{{ route('dashboard.paciente') }}" class="{{ request()->routeIs('dashboard.paciente') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> <span>Inicio</span>
            </a>
            @endrole


            {{-- ADMIN --}}
            @role('admin')
            <a href="{{ route('users') }}" class="{{ request()->routeIs('users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> <span>Usuarios</span>
            </a>

            <a href="{{ route('files') }}" class="{{ request()->routeIs('files*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-tree"></i> <span>Archivos</span>
            </a>

            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-column"></i> <span>Reportes</span>
            </a>
            @endrole


            {{-- ADMIN | MEDICO --}}
            @hasanyrole('admin|medico')
            <a href="{{ route('patients') }}" class="{{ request()->routeIs('patients*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> <span>Pacientes</span>
            </a>

            <a href="{{ route('records') }}" class="{{ request()->routeIs('records*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i> <span>Expedientes</span>
            </a>

            <a href="{{ route('invoice') }}" class="{{ request()->routeIs('invoice*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span>Facturación</span>
            </a>

            <a href="{{ route('payments') }}" class="{{ request()->routeIs('payments*') ? 'active' : '' }}">
                <i class="fa-solid fa-credit-card"></i> <span>Pagos</span>
            </a>
            @endhasanyrole


            {{-- PACIENTE --}}
            @role('paciente')
            <a href="{{ route('my_files') }}" class="{{ request()->routeIs('my_files*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i> <span>Mis Archivos</span>
            </a>

            <a href="{{ route('my_invoices') }}" class="{{ request()->routeIs('my_invoices*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span>Mi Facturación</span>
            </a>

            <a href="{{ route('my_payments') }}" class="{{ request()->routeIs('my_payments*') ? 'active' : '' }}">
                <i class="fa-solid fa-credit-card"></i> <span>Mis Pagos</span>
            </a>
            @endrole

        </aside>


        <main class="content">
            @yield('content')
        </main>

    </div>

</body>

</html>