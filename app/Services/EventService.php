<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService
{
    public function createEvent(array $data, ?int $organizerId): Event
    {
        if (!$organizerId) {
            throw new \RuntimeException('Organizer (authenticated user) is required to create event.');
        }

        $allowed = Arr::only($data, [
            'title',
            'slug',
            'description',
            'event_at',
            'location',
            'quota',
            'price',
            'status',
            'category_id',
        ]);

        $allowed['organizer_id'] = $organizerId;

        return Event::create($allowed);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $allowed = Arr::only($data, [
            'title',
            'slug',
            'description',
            'event_at',
            'location',
            'quota',
            'price',
            'status',
            'category_id',
        ]);

        $event->update($allowed);

        return $event->fresh();
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }

    public function listEvents(int $perPage = 10): LengthAwarePaginator
    {
        return Event::query()
            ->with(['category', 'organizer', 'images'])
            ->published()
            ->upcoming()
            ->orderBy('event_at')
            ->paginate($perPage);
    }

    public function findEventOrFail(int $id): Event
    {
        return Event::findOrFail($id);
    }
}