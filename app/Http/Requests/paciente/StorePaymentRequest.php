<?php

namespace App\Http\Requests\Paciente;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('paciente');
    }

    public function rules(): array
    {
        return [
            'invoice_id'        => 'required|exists:invoices,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }
}
