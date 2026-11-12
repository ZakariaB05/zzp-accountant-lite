<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    public const CATEGORIES = ['Apparatuur', 'Reiskosten', 'Software'];

    protected $fillable = ['user_id', 'title', 'category', 'expense_date', 'amount', 'vat_amount'];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'amount'       => 'float',
            'vat_amount'   => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
