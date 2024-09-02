<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryInterface $category;
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->category->store($request->validated());
        return ResponseHelper::success(trans('alert.add_success'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $this->category->update($category->id, $request->validated());
        return ResponseHelper::success(trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->category->delete($category->id);
            return ResponseHelper::success(trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(trans('alert.delete_constrained'));
        }
    }
}
