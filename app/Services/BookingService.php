<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingService
{
    public function createBooking(array $data): Booking
    {
        return Booking::create($data)
            ->load(['user', 'event']);
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        $allowed = collect($data)->only([
            'booking_date',
            'status',
        ])->toArray();

        $booking->update($allowed);

        return $booking->load(['user', 'event']);
    }

    public function deleteBooking(Booking $booking): bool
    {
        return $booking->delete();
    }

    public function listBookings(): LengthAwarePaginator
    {
        return Booking::with(['user', 'event'])
            ->latest()
            ->paginate(10);
    }
}