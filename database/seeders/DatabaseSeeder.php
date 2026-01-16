<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\PaymentMethod;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolePermissionSeeder::class);

        $admin = User::factory()->create([
            'name'  => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '5551234567',
            'is_active' => true,
        ]);

        $admin->assignRole('admin');

        $medico = User::factory()->create([
            'name'  => 'Doctor',
            'email' => 'medico@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '5551112233',
            'rfc' => 'PEJJ800101ABC',
            'business_name' => 'Consultorio Dr. Juan Pérez',
            'fiscal_address' => 'Av. Reforma 123, CDMX',
            'is_active' => true,
        ]);

        $medico->assignRole('medico');

        $paciente = User::factory()->create([
            'name'  => 'Paciente',
            'email' => 'paciente@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '5554447788',
            'rfc' => 'LOPM850505XYZ',
            'business_name' => 'Clínica Integral López',
            'fiscal_address' => 'Insurgentes Sur 456, CDMX',
            'is_active' => true,

        ]);

        $paciente->assignRole('paciente');

        $method = PaymentMethod::create([
            'name' => 'Tarjeta de crédito',
            'code' => 'card',
            'is_active' => true,
        ]);

        $invoice = Invoice::create([
            'patient_id' => $paciente->id,
            'doctor_id' => $medico->id,
            'folio' => 'FAC-001',
            'series' => 'A',
            'invoice_number' => 1,
            'receiver_name' => $paciente->name,
            'receiver_rfc' => $paciente->rfc,
            'receiver_email' => $paciente->email,
            'receiver_address' => $paciente->fiscal_address,
            'issuer_name' => $medico->business_name,
            'issuer_rfc' => $medico->rfc,
            'issuer_address' => $medico->fiscal_address,
            'subtotal' => 1293.10,
            'tax_rate' => 0.16,
            'tax_amount' => 206.90,
            'total' => 1500.00,
            'concept' => 'Consulta médica',
            'payment_method' => 'Tarjeta',
            'payment_terms' => 'Pago inmediato',
            'status' => 'pagada',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'paid_date' => now(),
        ]);

        Transaction::create([
            'invoice_id' => $invoice->id,
            'patient_id' => $paciente->id,
            'payment_method_id' => $method->id,
            'amount' => 1500,
            'fee' => 0,
            'net_amount' => 1500,
            'currency' => 'MXN',
            'status' => 'completada',
            'transaction_id' => 'TXN-' . uniqid(), 
            'processed_at' => now(),
        ]);
    }
}
