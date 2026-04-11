<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Arr;

class ReviewService
{
    public function createReview(array $data, int $userId): Review
    {
        $allowed = Arr::only($data, [
            'event_id',
            'rating',
            'comment',
        ]);

        $allowed['user_id'] = $userId;

        return Review::create($allowed)
            ->load(['user', 'event']);
    }

    public function updateReview(Review $review, array $data): Review
    {
        $allowed = Arr::only($data, [
            'event_id',
            'rating',
            'comment',
        ]);

        $review->update($allowed);

        return $review->load(['user', 'event']);
    }

    public function deleteReview(Review $review): bool
    {
        return $review->delete();
    }

    public function listReviews(int $perPage = 10)
    {
        return Review::with(['user', 'event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findReviewOrFail(int $id): Review
    {
        return Review::with(['user', 'event'])
            ->findOrFail($id);
    }

    public function getReviewsByEvent(int $eventId)
    {
        return Review::with('user')
            ->where('event_id', $eventId)
            ->latest()
            ->get();
    }
}