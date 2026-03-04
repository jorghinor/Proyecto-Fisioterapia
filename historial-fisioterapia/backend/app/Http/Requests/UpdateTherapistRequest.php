<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTherapistRequest extends FormRequest
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
        $therapistId = $this->route('therapist')->user_id;
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $therapistId,
            //'user_id' => 'required|exists:users,id',
            'license' => 'sometimes|required|string|max:255',
            'specialization' => 'sometimes|required|string|max:255',
        ];
    }
}
