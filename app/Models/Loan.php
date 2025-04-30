<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'total_amount',
        'daily_payment',
        'status',
        'decline_reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function canAcceptPayments(): bool
    {
        return !$this->isCompleted() && $this->status === 'approved';
    }
} 