<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\SubCategoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private SubCategoryInterface $subCategory;

    /**
     * Method __construct
     *
     * @param SubCategoryInterface $subCategory [explicite description]
     *
     * @return void
     */
    public function __construct(SubCategoryInterface $subCategory)
    {
        $this->subCategory = $subCategory;
    }



    /**
     * Method store
     *
     * @param SubCategoryRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();
        $data['category_id'] = $category->id;
        $this->subCategory->store($data);
        return ResponseHelper::success(trans('alert.add_success'));
    }

    /**
     * Method update
     *
     * @param SubCategoryRequest $request [explicite description]
     * @param SubCategory $subCategory [explicite description]
     *
     * @return JsonResponse
     */
    public function update(SubCategoryRequest $request, SubCategory $subCategory): JsonResponse
    {
        $this->subCategory->update($subCategory->id, $request->validated());
        return ResponseHelper::success(trans('alert.update_success'));
    }

    /**
     * Method destroy
     *
     * @param SubCategory $subCategory [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(SubCategory $subCategory): JsonResponse
    {
        try {
            $this->subCategory->delete($subCategory->id);
            return ResponseHelper::success(trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(trans('alert.delete_constrained'));
        }
    }

    /**
     * getByCategory
     *
     * @return JsonResponse
     */
    public function getByCategory(Category $category): JsonResponse
    {
        $subCategories = $this->subCategory->getByCategory($category->id);
        return ResponseHelper::success(SubCategoryResource::collection($subCategories));
    }
}
