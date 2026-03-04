<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
        $patientId = $this->route('patient')->id;
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'ci' => 'sometimes|required|string|max:255|unique:patients,ci,' . $patientId,
            'birth_date' => 'sometimes|required|date',
            'gender' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:patients,email,' . $patientId,
            'address' => 'nullable|string',
        ];
    }
}
