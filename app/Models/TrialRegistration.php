<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrialRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'nik',
        'program',
    ];
}
