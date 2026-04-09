<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookingService
{
    public function createBooking(array $data, ?int $userId): Booking
    {
        if (!$userId) {
            throw new \RuntimeException('Authenticated user is required to create booking.');
        }

        $allowed = Arr::only($data, [
            'event_id',
            'booking_date',
            'status',
        ]);

        $allowed['user_id'] = $userId;

        return Booking::create($allowed)
            ->load(['user', 'event']);
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        $allowed = Arr::only($data, [
            'booking_date',
            'status',
        ]);

        $booking->update($allowed);

        return $booking->fresh()->load(['user', 'event']);
    }

    public function deleteBooking(Booking $booking): bool
    {
        return $booking->delete();
    }

    public function listBookings(int $perPage = 10): LengthAwarePaginator
    {
        return Booking::query()
            ->with(['user', 'event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findBookingOrFail(int $id): Booking
    {
        return Booking::findOrFail($id);
    }
}