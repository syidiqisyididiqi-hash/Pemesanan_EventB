<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TicketService
{
    public function createTicket(array $data): Ticket
    {
        $allowed = collect($data)->only([
            'ticket_code',
            'booking_id',
            'status',
            'used_at',
        ])->toArray();

        return Ticket::create($allowed)
            ->load(['booking', 'booking.user', 'booking.event']);
    }

    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        $allowed = collect($data)->only([
            'ticket_code',
            'booking_id',
            'status',
            'used_at',
        ])->toArray();

        $ticket->update($allowed);

        return $ticket->load(['booking', 'booking.user', 'booking.event']);
    }

    public function deleteTicket(Ticket $ticket): bool
    {
        return $ticket->delete();
    }

    public function listTickets(int $perPage = 10): LengthAwarePaginator
    {
        return Ticket::with(['booking', 'booking.user', 'booking.event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findTicketOrFail(int $id): Ticket
    {
        return Ticket::with(['booking', 'booking.user', 'booking.event'])->findOrFail($id);
    }
}