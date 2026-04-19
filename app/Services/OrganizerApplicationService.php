<?php

namespace App\Services;

use App\Models\OrganizerApplication;
use App\Models\User;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrganizerApplicationService
{
    public function apply(User $user): OrganizerApplication
    {
        // Cek apakah user sudah punya aplikasi pending
        $existingApplication = OrganizerApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            throw new \Exception('User sudah memiliki aplikasi pending');
        }

        return OrganizerApplication::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function listApplications(): LengthAwarePaginator
    {
        return OrganizerApplication::with('user')
            ->latest()
            ->paginate(10);
    }

    public function approve(OrganizerApplication $application): OrganizerApplication
    {
        $organizerRole = Role::where('name', 'event_organizer')->first();

        // Update user role ke event_organizer
        $application->user->update([
            'role_id' => $organizerRole?->id,
        ]);

        // Update aplikasi status ke approved
        $application->update([
            'status' => 'approved',
        ]);

        return $application;
    }

    public function reject(OrganizerApplication $application, string $reason = null): OrganizerApplication
    {
        $application->update([
            'status' => 'rejected',
            'reason' => $reason,
        ]);

        return $application;
    }
}
