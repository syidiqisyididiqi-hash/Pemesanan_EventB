<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Arr;

class ImageService
{
    public function createImage(array $data): Image
    {
        $allowed = Arr::only($data, [
            'image_path',
            'imageable_id',
            'imageable_type',
        ]);

        return Image::create($allowed)
            ->load('imageable');
    }

    public function updateImage(Image $image, array $data): Image
    {
        $allowed = Arr::only($data, [
            'image_path',
        ]);

        $image->update($allowed);

        return $image->load('imageable');
    }

    public function deleteImage(Image $image): bool
    {
        return $image->delete();
    }

    public function listImages(int $perPage = 10)
    {
        return Image::with('imageable')
            ->latest()
            ->paginate($perPage);
    }

    public function findImageOrFail(int $id): Image
    {
        return Image::with('imageable')->findOrFail($id);
    }
}