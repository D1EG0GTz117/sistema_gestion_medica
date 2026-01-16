<?php

namespace App\Http\Requests\Medico;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('medico');
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:users,id',
            'concept' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ];
    }
}
