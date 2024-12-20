<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\BlogInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use PaginationTrait;
    private BlogInterface $blog;
    private BlogService $service;
    public function __construct(BlogInterface $blog, BlogService $service)
    {
        $this->blog = $blog;
        $this->service = $service;
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
        $blogs = $this->blog->customPaginate($request);
        $data['paginate'] = $this->customPaginate($blogs->currentPage(), $blogs->lastPage());
        $data['data'] = BlogResource::collection($blogs);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param BlogRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(BlogRequest $request): JsonResponse
    {
        $this->blog->store($this->service->store($request));
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method showAndCountView
     *
     * @param Request $request [explicite description]
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function showLanding(Request $request, string $slug): JsonResponse
    {
        $blog = $this->blog->showWithSlug($slug);
        try {
            $this->service->handleCreateBlogView($request, $blog);
        } catch (\Throwable $e) {
        }
        return ResponseHelper::success(BlogResource::make($blog), trans('alert.fetch_success'));
    }
    /**
     * Method show
     *
     * @param Blog $blog [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
    {
        $blog = $this->blog->show($blog->id);
        return ResponseHelper::success(BlogResource::make($blog), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param BlogRequest $request [explicite description]
     * @param Blog $blog [explicite description]
     *
     * @return JsonResponse
     */
    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        $this->blog->update($blog->id, $this->service->update($request, $blog));
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Blog $blog [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        $this->blog->delete($this->service->delete($blog));
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
