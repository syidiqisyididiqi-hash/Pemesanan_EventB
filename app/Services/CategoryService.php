<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
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
}