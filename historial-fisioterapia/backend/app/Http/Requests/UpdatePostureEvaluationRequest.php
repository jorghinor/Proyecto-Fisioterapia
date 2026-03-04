<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostureEvaluationRequest extends FormRequest
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
            'evaluation_date' => 'sometimes|required|date',
            'anterior_view' => 'nullable|string',
            'posterior_view' => 'nullable|string',
            'lateral_view' => 'nullable|string',
            /*'cervical_notes' => 'nullable|string',
            'dorsal_notes' => 'nullable|string',
            'lumbar_notes' => 'nullable|string',
            'pelvic_notes' => 'nullable|string',
            'lower_limbs_notes' => 'nullable|string',
            'upper_limbs_notes' => 'nullable|string',*/
        ];
    }
}
