<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $reviews = $this->reviewService->listReviews();

        return response()->json([
            'message' => 'Reviews retrieved successfully',
            'data' => $reviews
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->createReview(
            $request->validated(),
            Auth::id()
        );

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $review
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Review $review): JsonResponse
    {
        $review->load(['user', 'event']);

        return response()->json([
            'message' => 'Review retrieved successfully',
            'data' => $review
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review): JsonResponse
    {
        $review = $this->reviewService->updateReview(
            $review,
            $request->validated()
        );

        return response()->json([
            'message' => 'Review updated successfully',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review): JsonResponse
    {
        $this->reviewService->deleteReview($review);

        return response()->json(null, 204);
    }
}