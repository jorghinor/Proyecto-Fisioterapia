<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostureEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'evaluation_date',
        'anterior_view',
        'posterior_view',
        'lateral_view',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}