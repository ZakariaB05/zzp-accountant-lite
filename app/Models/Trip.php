<?php

namespace App\Models;

use App\Helpers\TaxCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $fillable = ['user_id', 'trip_date', 'from_location', 'to_location', 'kilometers', 'vehicle'];

    protected function casts(): array
    {
        return [
            'trip_date'  => 'date',
            'kilometers' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Gebruik: $trip->deduction
    public function getDeductionAttribute(): float
    {
        return TaxCalculator::kmDeduction($this->kilometers);
    }
}
