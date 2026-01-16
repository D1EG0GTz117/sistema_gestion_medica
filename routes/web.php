<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MyFileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MyInvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MyPaymentController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'create'])
    ->name('register.create');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| RESET PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/forgotpassword', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgotpassword', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return "Token recibido correctamente: " . $token;
})->name('password.reset');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| DASHBOARDS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/admin', [DashboardController::class, 'index'])
        ->name('dashboard.admin');

    Route::get('/dashboard/medico', [DashboardController::class, 'index'])
        ->name('dashboard.medico');

    Route::get('/dashboard/paciente', [DashboardController::class, 'index'])
        ->name('dashboard.paciente');
});

/*
|--------------------------------------------------------------------------
| ADMIN (SIDENAV: USUARIOS / ARCHIVOS / REPORTES)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/files', [FileController::class, 'index'])->name('files');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('/reports/export/medical-files', [ReportController::class, 'exportMedicalFiles'])
        ->name('reports.export.medical-files');
});

/*
|--------------------------------------------------------------------------
| ARCHIVOS (GENERAL)
|--------------------------------------------------------------------------
*/

Route::get('/files', [FileController::class, 'index'])->name('files');
Route::get('/files/{medicalFile}/download', [FileController::class, 'download'])->name('files.download');
Route::get('/files/{medicalFile}/versions', [FileController::class, 'versions'])->name('files.versions');
Route::post('/files/zip', [FileController::class, 'downloadZip'])->name('files.zip');

/*
|--------------------------------------------------------------------------
| ADMIN | MEDICO
| SIDENAV: PACIENTES / EXPEDIENTES / FACTURACIÓN / PAGOS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin|medico'])->group(function () {

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    Route::get('/records', [RecordController::class, 'index'])->name('records');
    Route::post('/records', [RecordController::class, 'store'])->name('records.store');
    Route::get('/records/{file}/download', [RecordController::class, 'download'])
        ->name('records.download');

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');
    Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'download'])
        ->name('invoice.download');

    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments');
});

/*
|--------------------------------------------------------------------------
| ADMIN | PACIENTE
| SIDENAV: MIS ARCHIVOS / MI FACTURACIÓN / MIS PAGOS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin|paciente'])->group(function () {

    Route::get('/my_files', [MyFileController::class, 'index'])->name('my_files');
    Route::get('/my_files/{medicalFile}/download', [MyFileController::class, 'download'])
        ->name('my_files.download');

    Route::get('/my_invoices', [MyInvoiceController::class, 'index'])
        ->name('my_invoices');
    Route::get('/my_invoices/{invoice}/download', [MyInvoiceController::class, 'download'])
        ->name('my_invoices.download');

    Route::get('/my_payments', [MyPaymentController::class, 'index'])
        ->name('my_payments');
});
