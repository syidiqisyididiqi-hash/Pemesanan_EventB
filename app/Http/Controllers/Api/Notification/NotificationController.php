<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $notifications = $this->notificationService->listNotifications();

        return response()->json([
            'message' => 'Notifications retrieved successfully',
            'data' => $notifications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request): JsonResponse
    {
        $notification = $this->notificationService->createNotification(
            $request->validated()
        );

        return response()->json([
            'message' => 'Notification created successfully',
            'data' => $notification
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification): JsonResponse
    {
        $notification->load('user');

        return response()->json([
            'message' => 'Notification retrieved successfully',
            'data' => $notification
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateNotificationRequest $request,
        Notification $notification
    ): JsonResponse {
        $notification = $this->notificationService->updateNotification(
            $notification,
            $request->validated()
        );

        return response()->json([
            'message' => 'Notification updated successfully',
            'data' => $notification
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification): JsonResponse
    {
        $this->notificationService->deleteNotification($notification);

        return response()->json(null, 204);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        $notification = $this->notificationService
            ->markNotificationAsRead($notification);

        return response()->json([
            'message' => 'Notification marked as read',
            'data' => $notification
        ]);
    }
}