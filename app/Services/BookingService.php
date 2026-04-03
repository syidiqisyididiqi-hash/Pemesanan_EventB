<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingService
{
    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking;
    }

    public function deleteBooking(Booking $booking): bool
    {
        return $booking->delete();
    }

    public function listBookings(): LengthAwarePaginator
    {
        return Booking::query()
            ->latest()
            ->paginate(10);
    }
}