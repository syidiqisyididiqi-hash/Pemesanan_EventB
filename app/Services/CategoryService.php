<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function createCategory(array $data): Category
    {
        $category = new Category();
        $category->fill($data);
        $category->save();

        return $category;
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->fill($data);
        $category->save();

        return $category;
    }

    public function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }

    public function listCategories(): LengthAwarePaginator
    {
        return Category::query()
            ->latest()
            ->paginate(10);
    }

    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }
}