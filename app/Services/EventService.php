<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function createEvent(array $data, int $organizerId): Event
    {
        $data['organizer_id'] = $organizerId;

        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $event->update($data);

        return $event->fresh();
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }

    public function listEvent(): LengthAwarePaginator
    {
        return Event::query()
            ->with(['category', 'organizer', 'images'])
            ->published()
            ->upcoming()
            ->orderBy('event_at')
            ->paginate(10);
    }
}