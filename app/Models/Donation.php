<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'reference', 'name', 'email', 'phone', 'amount', 'currency',
        'original_amount', 'original_currency', 'fx_rate_to_rwf', 'purpose',
        'message', 'status', 'payment_status', 'payment_method', 'confirmation_code',
        'order_tracking_id', 'redirect_url', 'gateway_response', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'original_amount' => 'decimal:2',
            'fx_rate_to_rwf' => 'decimal:2',
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function getIsCompletedAttribute(): bool
    {
        return in_array(strtoupper((string) $this->status), ['COMPLETED', 'SUCCESS', 'PAID'], true);
    }

    public function scopeCompleted(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereIn('status', ['COMPLETED', 'SUCCESS', 'PAID']);
    }
}
