<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MobilityArcResource extends JsonResource
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
            'joint' => $this->joint,
            'flexion' => $this->flexion,
            'extension' => $this->extension,
            'abduction' => $this->abduction,
            'adduction' => $this->adduction,
            'internal_rotation' => $this->internal_rotation,
            'external_rotation' => $this->external_rotation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
