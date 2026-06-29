<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'expertise',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(CourseClass::class, 'tutor_id');
    }
}
