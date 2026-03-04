<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionalAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'assessment_date',
        'notes',
        'barthel_index',
        'lawton_brody_scale',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}