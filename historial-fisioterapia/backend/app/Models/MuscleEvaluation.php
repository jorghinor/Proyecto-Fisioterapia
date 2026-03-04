<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuscleEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'muscle',
        'strength',
        'evaluation_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}