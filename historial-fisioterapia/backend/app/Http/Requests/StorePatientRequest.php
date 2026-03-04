<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ci' => 'required|string|max:255|unique:patients',
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:patients',
            'address' => 'nullable|string',
        ];
    }
}
