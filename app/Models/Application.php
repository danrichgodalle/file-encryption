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
        'city',
        'state',
        'zip_code',
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
        'employer_city',
        'employer_state',
        'employer_zip_code',
        'businesses',
        'spouse_employment',
        'spouse_position',
        'spouse_employer_name',
        'spouse_employer_address',
        'spouse_employer_city',
        'spouse_employer_state',
        'spouse_employer_zip_code',
        'monthly_income',
        'properties',
        'photo',
        'sketch',
        'signature',
        'decline_reason',
        'user_id',
        'encryption_key',
    ];

    protected $casts = [
        'personal_properties' => 'array',
        'businesses' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
