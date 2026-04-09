<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TicketService
{
    public function createTicket(array $data): Ticket
    {
        $allowed = Arr::only($data, [
            'ticket_code',
            'booking_id',
            'status',
            'used_at',
        ]);

        return Ticket::create($allowed)
            ->load(['booking.user', 'booking.event']);
    }

    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        $allowed = Arr::only($data, [
            'ticket_code',
            'booking_id',
            'status',
            'used_at',
        ]);

        $ticket->update($allowed);

        return $ticket->fresh()
            ->load(['booking.user', 'booking.event']);
    }

    public function deleteTicket(Ticket $ticket): bool
    {
        return $ticket->delete();
    }

    public function listTickets(int $perPage = 10): LengthAwarePaginator
    {
        return Ticket::query()
            ->with(['booking.user', 'booking.event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findTicketOrFail(int $id): Ticket
    {
        return Ticket::query()
            ->with(['booking.user', 'booking.event'])
            ->findOrFail($id);
    }
}