<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Models\Notification;
use App\Http\Requests\Notification\UpdateNotificationRequest;





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
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);

        $notifications = $this->notificationService->listNotifications($perPage);

        return response()->json($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request): JsonResponse
    {
        $notification = $this->notificationService->createNotification($request->validated());

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
        return response()->json($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateNotificationRequest $request,
        Notification $notification
    ): JsonResponse {
        $updated = $this->notificationService
            ->updateNotification($notification, $request->validated());

        return response()->json([
            'message' => 'Notification updated successfully',
            'data' => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification): JsonResponse
    {
        $this->notificationService->deleteNotification($notification);

        return response()->json([
            'message' => 'Notification deleted successfully'
        ]);
    }

    public function markAsRead(Notification $notification): JsonResponse
    {
        $updated = $this->notificationService
            ->markNotificationAsRead($notification);

        return response()->json([
            'message' => 'Notification marked as read',
            'data' => $updated
        ]);
    }
}
