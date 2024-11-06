<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\PaginationTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryInterface $category;
    use PaginationTrait;
    /**
     * Method __construct
     *
     * @param CategoryInterface $category [explicite description]
     *
     * @return void
     */
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }
    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('page')) {
            $categories = $this->category->customPaginate($request);
            $data['paginate'] = $this->customPaginate($categories->currentPage(), $categories->lastPage());
            $data['data'] = CategoryResource::collection($categories);
        } else {
            $categories = $this->category->search($request);
            $data['data'] = CategoryResource::collection($categories);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->category->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $this->category->update($category->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->category->delete($category->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(true, trans('alert.delete_constrained'));
        }
    }
}
