<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $booking_id
 * @property float $amount
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $payment_date
 * @property string $status
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code',
        'booking_id',
        'amount',
        'payment_method',
        'payment_date',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}