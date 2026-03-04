<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MuscleEvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'muscle' => $this->muscle,
            'strength' => $this->strength,
            'evaluation_date' => $this->evaluation_date,
            /*'muscle_group' => $this->muscle_group,
            'strength_grade' => $this->strength_grade,
            'notes' => $this->notes,*/
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
