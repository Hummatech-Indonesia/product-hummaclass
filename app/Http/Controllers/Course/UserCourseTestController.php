<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestHistoryResource;
use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserCourseTestResource;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseTestController extends Controller
{
    use PaginationTrait;
    private UserCourseTestInterface $userCourseTest;
    public function __construct(UserCourseTestInterface $userCourseTest)
    {
        $this->userCourseTest = $userCourseTest;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userCourseTests = $this->userCourseTest->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourseTests->currentPage(), $userCourseTests->lastPage());
        $data['data'] = TestHistoryResource::collection($userCourseTests);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->userCourseTest->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
}
