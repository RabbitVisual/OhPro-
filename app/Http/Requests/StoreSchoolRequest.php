<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:50',
        ];
    }
}
