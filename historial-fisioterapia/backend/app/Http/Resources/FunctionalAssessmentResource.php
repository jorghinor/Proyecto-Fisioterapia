<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FunctionalAssessmentResource extends JsonResource
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
            'assessment_date' => $this->assessment_date,
            'notes' => $this->notes,
            'barthel_index' => $this->barthel_index,
            'lawton_brody_scale' => $this->lawton_brody_scale,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
