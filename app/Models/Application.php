<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $fillable = [
        'name',
        'date_of_birth',
        'age',
        'civil_status',
        'spouse',
        'contact_person',
        'source_of_income',
        'monthly_income',
        'personal_properties',
        'photo'
    ];

    protected $casts = [
        'personal_properties' => 'array',
    ];
}
