<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilityArc extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'joint',
        'flexion',
        'extension',
        'abduction',
        'adduction',
        'internal_rotation',
        'external_rotation',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}