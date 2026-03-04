<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFunctionalAssessmentRequest extends FormRequest
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
            'assessment_date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
            'barthel_index' => 'nullable|integer',
            'lawton_brody_scale' => 'nullable|integer',
        ];
    }
}
