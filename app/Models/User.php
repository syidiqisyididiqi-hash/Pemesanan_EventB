<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
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
            'user_id',    
            'booking_id', 
            'id',         
            'id'          
        );
    }

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Payment::class,
            Booking::class,
            'user_id',    
            'booking_id', 
            'id',
            'id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}