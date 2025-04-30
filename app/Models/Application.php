<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    public $fillable = [
        'name',
        'nick_name',
        'address',
        'tel_no',
        'cell_no',
        'length_of_stay',
        'ownership',
        'rent_amount',
        'date_of_birth',
        'place_of_birth',
        'age',
        'civil_status',
        'dependents',
        'contact_person',
        'employment',
        'position',
        'employer_name',
        'employer_address',
        'spouse_employment',
        'spouse_position',
        'spouse_employer_name',
        'spouse_employer_address',
        'monthly_income',
        'properties',
        'photo',
        'sketch',
        'signature',
        'decline_reason',
        'user_id',
    ];

    protected $casts = [
        'personal_properties' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
