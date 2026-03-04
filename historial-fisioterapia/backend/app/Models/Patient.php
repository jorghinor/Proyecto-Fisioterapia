<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'birth_date',
        'gender',
        'phone',
        'email',
        'address',
        'therapist_id',
    ];

    public function functionalAssessments()
    {
        return $this->hasMany(FunctionalAssessment::class);
    }

    public function gaitAnalyses()
    {
        return $this->hasMany(GaitAnalysis::class);
    }

    public function mobilityArcs()
    {
        return $this->hasMany(MobilityArc::class);
    }

    public function muscleEvaluations()
    {
        return $this->hasMany(MuscleEvaluation::class);
    }

    public function postureEvaluations()
    {
        return $this->hasMany(PostureEvaluation::class);
    }

    /**
     * Get the therapist that owns the patient.
     */
    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    /**
     * Get the patient's full name.
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
