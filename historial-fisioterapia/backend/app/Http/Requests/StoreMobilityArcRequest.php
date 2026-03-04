<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMobilityArcRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'joint' => 'required|string|max:255',
            'flexion' => 'nullable|numeric',
            'extension' => 'nullable|numeric',
            'abduction' => 'nullable|numeric',
            'adduction' => 'nullable|numeric',
            'internal_rotation' => 'nullable|numeric',
            'external_rotation' => 'nullable|numeric',
        ];
    }
}
