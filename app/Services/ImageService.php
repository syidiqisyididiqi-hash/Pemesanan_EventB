<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function createImage(Model $imageable, string $path): Image
    {
        return $imageable->images()->create([
            'image_path' => $path,
        ])->load('imageable');
    }

    public function updateImage(Image $image, string $path): Image
    {
        if ($image->image_path) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            } elseif (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        }

        $image->update([
            'image_path' => $path,
        ]);

        return $image->load('imageable');
    }

    public function deleteImage(Image $image): bool
    {
        if ($image->image_path) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            } elseif (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        }

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