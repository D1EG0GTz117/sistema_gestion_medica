<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'folio',
        'series',
        'invoice_number',
        'receiver_name',
        'receiver_rfc',
        'receiver_email',
        'receiver_address',
        'issuer_name',
        'issuer_rfc',
        'issuer_address',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'concept',
        'notes',
        'payment_method',
        'payment_terms',
        'status',
        'issue_date',
        'due_date',
        'paid_date',
        'pdf_path',
        'xml_path',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:4',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];


    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Transaction::class);
    }
}
