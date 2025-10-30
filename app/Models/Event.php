<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    public const SEATS_PER_CATEGORY = 40;

    protected $fillable = [
        'venue_id',
        'title',
        'description',
        'image_url',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketCategories(): BelongsToMany
    {
        return $this->belongsToMany(TicketCategory::class, 'event_ticket_category')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function isPastEvent(): bool
    {
        return $this->event_date->isPast();
    }

    public function isSoldOut(): bool
    {
        $categoryCount = $this->ticketCategories()->count();
        $totalSeats = $categoryCount * self::SEATS_PER_CATEGORY;

        // Count sold tickets (non-deleted)
        $soldTickets = $this->tickets()->whereNull('deleted_at')->count();

        return $soldTickets >= $totalSeats;
    }

    public function getAvailableStockForCategory(int $categoryId): int
    {
        $soldTickets = $this->tickets()
            ->where('category_id', $categoryId)
            ->whereNull('deleted_at')
            ->count();

        return max(0, self::SEATS_PER_CATEGORY - $soldTickets);
    }

    public function isDisabled(): bool
    {
        return $this->isPastEvent() || $this->isSoldOut();
    }

    public function getStatusTextAttribute(): string
    {
        if ($this->isPastEvent()) {
            return 'Tarihi Geçmiş';
        }

        if ($this->isSoldOut()) {
            return 'Tükendi';
        }

        return 'Satışta';
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->isPastEvent()) {
            return 'bg-gray-500';
        }

        if ($this->isSoldOut()) {
            return 'bg-red-500';
        }

        return 'bg-green-500';
    }

    public function getDisabledMessageAttribute(): string
    {
        if ($this->isPastEvent()) {
            return 'Etkinlik Tarihi Geçmiş';
        }

        return 'Biletler Tükendi';
    }

    public function scopeSearch($query, ?string $searchTerm)
    {
        return $query->when($searchTerm, function ($q, $searchTerm) {
            $q->where(function ($inner) use ($searchTerm) {
                $inner->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhereHas('venue', function ($venueQuery) use ($searchTerm) {
                        $venueQuery->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('address', 'like', "%{$searchTerm}%");
                    });
            });
        });
    }
}
