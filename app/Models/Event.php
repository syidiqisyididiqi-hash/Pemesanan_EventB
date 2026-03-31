<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_at',
        'location',
        'quota',
        'price',
        'status',
        'category_id',
        'organizer_id'
    ];

    protected $casts = [
        'event_at' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(
            Ticket::class,
            Booking::class,
            'event_id',   
            'booking_id', 
            'id',         
            'id'          
        );
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_at', '>', now());
    }
}
