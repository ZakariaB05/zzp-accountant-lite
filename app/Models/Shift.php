<?php

namespace App\Models;

use App\Helpers\TaxCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $fillable = ['user_id', 'client_name', 'work_date', 'hours', 'hourly_rate', 'vat_rate'];

    protected function casts(): array
    {
        return [
            'work_date'   => 'date',
            'hours'       => 'float',
            'hourly_rate' => 'float',
            'vat_rate'    => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Gebruik: $shift->amount_excl
    public function getAmountExclAttribute(): float
    {
        return TaxCalculator::amountExclVat($this->hours, $this->hourly_rate);
    }

    public function getVatAmountAttribute(): float
    {
        return TaxCalculator::vatAmount($this->amount_excl, $this->vat_rate);
    }

    public function getAmountInclAttribute(): float
    {
        return round($this->amount_excl + $this->vat_amount, 2);
    }
}
