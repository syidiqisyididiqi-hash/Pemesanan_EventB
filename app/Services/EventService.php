<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function createEvent(array $data): Event
    {
        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }

    public function listEvent(): LengthAwarePaginator
    {
        return Event::query()
            ->latest()
            ->paginate(10);
    }
}