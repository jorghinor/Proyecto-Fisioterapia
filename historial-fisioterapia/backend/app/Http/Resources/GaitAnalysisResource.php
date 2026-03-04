<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GaitAnalysisResource extends JsonResource
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
            'analysis_date' => $this->analysis_date,
            'gait_pattern' => $this->gait_pattern,
            'stride_length' => $this->stride_length,
            'cadence' => $this->cadence,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
