<?php

namespace App\Http\Controllers\Api\Image;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;

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
        return response()->json([
            'message' => 'Daftar gambar',
            'data' => $this->imageService->listImages()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $image = $this->imageService->createImage($request->validated());

        return response()->json([
            'message' => 'Gambar berhasil ditambahkan',
            'data' => $image
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image): JsonResponse
    {
        $image->load('imageable');

        return response()->json([
            'message' => 'Gambar ditemukan',
            'data' => $image
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image): JsonResponse
    {
        $image = $this->imageService->updateImage($image, $request->validated());

        return response()->json([
            'message' => 'Gambar berhasil diperbarui',
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
