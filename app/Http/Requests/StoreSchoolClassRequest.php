<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:30',
            'grade_level' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:2000|max:2100',
        ];
    }
}
