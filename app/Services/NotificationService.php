<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Arr;

class NotificationService
{
    public function createNotification(array $data): Notification
    {
        $allowed = Arr::only($data, [
            'user_id',
            'title',
            'message',
        ]);

        $allowed['is_read'] = $data['is_read'] ?? false;

        return Notification::create($allowed)
            ->load('user');
    }

    public function updateNotification(Notification $notification, array $data): Notification
    {
        $allowed = Arr::only($data, [
            'title',
            'message',
            'is_read',
        ]);

        $notification->fill($allowed);
        $notification->save();

        return $notification->load('user');
    }

    public function deleteNotification(Notification $notification): bool
    {
        return $notification->delete();
    }

    public function listNotifications(int $perPage = 10)
    {
        return Notification::with('user')
            ->latest()
            ->paginate($perPage);
    }

    public function findNotificationOrFail(int $id): Notification
    {
        return Notification::with('user')
            ->findOrFail($id);
    }

    public function getNotificationsByUser(int $userId)
    {
        return Notification::with('user')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function markNotificationAsRead(Notification $notification): Notification
    {
        if ($notification->is_read) {
            return $notification->load('user');
        }

        $notification->is_read = true;
        $notification->save();

        return $notification->load('user');
    }
}