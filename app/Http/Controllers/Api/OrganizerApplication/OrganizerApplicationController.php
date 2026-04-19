<?php

namespace App\Http\Controllers\Api\OrganizerApplication;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication;
use App\Services\OrganizerApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizerApplicationController extends Controller
{
    protected OrganizerApplicationService $organizerApplicationService;

    public function __construct(OrganizerApplicationService $organizerApplicationService)
    {
        $this->organizerApplicationService = $organizerApplicationService;
    }

    /**
     * Member apply untuk menjadi organizer
     */
    public function apply(Request $request): JsonResponse
    {
        try {
            $application = $this->organizerApplicationService->apply($request->user());

            return response()->json([
                'message' => 'Aplikasi organizer berhasil dikirim',
                'data' => $application,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Admin melihat semua aplikasi
     */
    public function index(): JsonResponse
    {
        $applications = $this->organizerApplicationService->listApplications();

        return response()->json([
            'message' => 'Aplikasi organizer berhasil diambil',
            'data' => $applications,
        ]);
    }

    /**
     * Admin approve aplikasi
     */
    public function approve(OrganizerApplication $application): JsonResponse
    {
        try {
            $approved = $this->organizerApplicationService->approve($application);

            return response()->json([
                'message' => 'Aplikasi berhasil disetujui',
                'data' => $approved->load('user'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Admin reject aplikasi
     */
    public function reject(Request $request, OrganizerApplication $application): JsonResponse
    {
        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $rejected = $this->organizerApplicationService->reject(
                $application,
                $validated['reason'] ?? null
            );

            return response()->json([
                'message' => 'Aplikasi berhasil ditolak',
                'data' => $rejected,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
