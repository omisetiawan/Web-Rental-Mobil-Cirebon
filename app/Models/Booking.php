<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $car_id
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $start_date
 * @property string $end_date
 * @property float $total_price
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read int $duration
 * @property-read bool $is_active
 * @property-read bool $is_upcoming
 * @property-read bool $is_past
 * @property-read Car $car
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'customer_name',
        'customer_phone',
        'start_date',
        'end_date',
        'duration',
        'total_price',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
        'duration' => 'integer'
    ];

    /**
     * Get the car that owns the booking
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get booking duration in days
     */
    public function getDurationAttribute(): int
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date) + 1;
        }

        return $this->attributes['duration'] ?? 0;
    }

    /**
     * Check if booking is active (currently ongoing)
     */
    public function getIsActiveAttribute(): bool
    {
        $now = now();
        return $this->status === 'approved' &&
            $this->start_date <= $now &&
            $this->end_date >= $now;
    }

    /**
     * Check if booking is upcoming
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->status === 'approved' && $this->start_date > now();
    }

    /**
     * Check if booking is past
     */
    public function getIsPastAttribute(): bool
    {
        return $this->end_date < now();
    }

    /**
     * Scope for active bookings
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'approved')
            ->where('start_date', '>', now());
    }

    /**
     * Scope for pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'approved']) &&
            $this->start_date > now()->addDays(1);
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
