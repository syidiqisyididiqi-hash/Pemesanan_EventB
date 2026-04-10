<?php

namespace App\Http\Controllers\Api\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Models\Event;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $images = $this->imageService->listImages();

        return response()->json([
            'message' => 'Images retrieved successfully',
            'data' => $images
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $event = Event::findOrFail($data['event_id']);
        $path = $request->file('image')->store('images', 'public');

        $image = $this->imageService->createImage($event, $path);

        return response()->json([
            'message' => 'Image created successfully',
            'data' => $image
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image): JsonResponse
    {
        $image = $this->imageService->findImageOrFail($image->id);

        return response()->json([
            'message' => 'Image retrieved successfully',
            'data' => $image
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $image = $this->imageService->updateImage($image, $path);
        } elseif (isset($data['image_path'])) {
            $image = $this->imageService->updateImage($image, $data['image_path']);
        }

        return response()->json([
            'message' => 'Image updated successfully',
            'data' => $image
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image): JsonResponse
    {
        $this->imageService->deleteImage($image);

        return response()->json(null, 204);
    }
}