<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'purpose',
        'message',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Accessor untuk purpose label
     */
    public function getPurposeLabelAttribute()
    {
        $labels = [
            'booking' => 'Booking Mobil',
            'info' => 'Informasi',
            'partnership' => 'Kerjasama',
            'complaint' => 'Keluhan',
            'other' => 'Lainnya'
        ];

        return $labels[$this->purpose] ?? $this->purpose;
    }

    /**
     * Accessor untuk purpose icon
     */
    public function getPurposeIconAttribute()
    {
        $icons = [
            'booking' => 'calendar-check',
            'info' => 'info-circle',
            'partnership' => 'handshake',
            'complaint' => 'exclamation-triangle',
            'other' => 'question-circle'
        ];

        return $icons[$this->purpose] ?? 'envelope';
    }

    /**
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'unread' => 'Belum Dibaca',
            'read' => 'Sudah Dibaca',
            'replied' => 'Sudah Dibalas'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Scope untuk filtering
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeByPurpose($query, $purpose)
    {
        return $query->where('purpose', $purpose);
    }
}
