<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestHistoryResource;
use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserCourseTestResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseTestController extends Controller
{
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
    public function index(): JsonResponse
    {
        $userCourseTests = $this->userCourseTest->get();
        return ResponseHelper::success(TestHistoryResource::collection($userCourseTests), trans('alert.fetch_success'));
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
