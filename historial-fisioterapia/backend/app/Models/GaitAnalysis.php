<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaitAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'analysis_date',
        'video_url',
        'observations',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}