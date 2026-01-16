<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['medico', 'administrador']);
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:users,id',
            'concept'    => 'required|string',
            'items'      => 'required|array|min:1',
            'items.*.concept' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }
}
