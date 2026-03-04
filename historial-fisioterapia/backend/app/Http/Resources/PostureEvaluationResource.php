<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostureEvaluationResource extends JsonResource
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
            'evaluation_date' => $this->evaluation_date,
            'anterior_view' => $this->anterior_view,
            'posterior_view' => $this->posterior_view,
            'lateral_view' => $this->lateral_view,
            /*'cervical_notes' => $this->cervical_notes,
            'dorsal_notes' => $this->dorsal_notes,
            'lumbar_notes' => $this->lumbar_notes,
            'pelvic_notes' => $this->pelvic_notes,
            'lower_limbs_notes' => $this->lower_limbs_notes,
            'upper_limbs_notes' => $this->upper_limbs_notes,*/
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
