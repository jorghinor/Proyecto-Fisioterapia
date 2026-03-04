<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'license',
        'specialization',
    ];

    /**
     * Get the user that owns the therapist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the patients for the therapist.
     */
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    /**
     * Get the therapist's name from the associated user.
     */
    public function getNameAttribute(): string
    {
        return $this->user->name;
    }
}