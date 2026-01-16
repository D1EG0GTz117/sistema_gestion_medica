<?php

namespace App\Http\Requests\Medico;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('medico');
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:medical_file_categories,id',
            'title' => 'sometimes|string|max:255',
            'file' => 'sometimes|file|max:51200|mimes:pdf,jpg,jpeg,png,dcm',
            'study_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }
}
