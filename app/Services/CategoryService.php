<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function createCategory(array $data): Category
    {
        $allowed = Arr::only($data, [
            'name',
            'slug',
            'description',
        ]);

        return Category::create($allowed);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $allowed = Arr::only($data, [
            'name',
            'slug',
            'description',
        ]);

        $category->update($allowed);

        return $category;
    }

    public function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }

    public function listCategories(int $perPage = 10): LengthAwarePaginator
    {
        return Category::latest()->paginate($perPage);
    }

    public function findCategoryOrFail(int $id): Category
    {
        return Category::findOrFail($id);
    }
}