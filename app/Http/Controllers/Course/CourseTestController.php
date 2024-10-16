<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseTestInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTestRequest;
use App\Http\Requests\UserCourseTestRequest;
use App\Http\Resources\CourseTestResource;
use App\Http\Resources\ModuleQuestionResource;
use App\Http\Resources\UserCourseTestResource;
use App\Models\Course;
use App\Models\CourseTest;
use App\Models\UserCourseTest;
use App\Services\CourseTestService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseTestController extends Controller
{
    use PaginationTrait;
    private CourseTestInterface $courseTest;
    private UserCourseTestInterface $userCourseTest;
    private ModuleQuestionInterface $moduleQuestion;
    private CourseTestService $service;
    public function __construct(CourseTestInterface $courseTest, CourseTestService $service, UserCourseTestInterface $userCourseTest, ModuleQuestionInterface $moduleQuestion)
    {
        $this->courseTest = $courseTest;
        $this->userCourseTest = $userCourseTest;
        $this->moduleQuestion = $moduleQuestion;
        $this->service = $service;
    }
    public function index(Course $course): JsonResponse
    {
        $courseTest = $this->courseTest->show($course->id);
        return ResponseHelper::success(CourseTestResource::make($courseTest), trans('alert.fetch_success'));
    }
    public function show(Request $request, CourseTest $courseTest): JsonResponse
    {
        $this->service->store($courseTest);
        $request->merge(['course_id' => $courseTest->id]);
        $userCourseTests = $this->userCourseTest->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourseTests->currentPage(), $userCourseTests->lastPage());
        $data['data'] = UserCourseTestResource::collection($userCourseTests);
        return responsehelper::success($data, trans('alert.fetch_success'));
    }
    public function get(): JsonResponse
    {
        $courseTests = $this->courseTest->get();
        return ResponseHelper::success(CourseTestResource::collection($courseTests), trans('alert.fetch_success'));
    }
    public function preTest(Request $request, CourseTest $courseTest): JsonResponse
    {
        $preTest = $this->service->preTest($courseTest);
        $request->merge(['id' => $preTest['questions']]);
        $questions = $this->moduleQuestion->paginate($request);
        $data['paginate'] = $this->customPaginate($questions->currentPage(), $questions->lastPage());
        $data['data'] = ModuleQuestionResource::collection($questions);
        $data['user_quiz'] = UserCourseTestResource::make($preTest['preTest']);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    public function postTest(Request $request, CourseTest $courseTest): JsonResponse
    {
        try {
            $postTest = $this->service->postTest($courseTest);
            $request->merge(['id' => $postTest['questions']]);
            $questions = $this->moduleQuestion->paginate($request);
            $data['paginate'] = $this->customPaginate($questions->currentPage(), $questions->lastPage());
            $data['data'] = ModuleQuestionResource::collection($questions);
            $data['user_quiz'] = UserCourseTestResource::make($postTest['postTest']);
            return ResponseHelper::success($data, trans('alert.fetch_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.not_pre_test_yet'));
        }
    }
    public function submit(UserCourseTestRequest $request, UserCourseTest $userCourseTest): JsonResponse
    {
        $this->service->submit($request, $userCourseTest);
        return ResponseHelper::success(null, trans('alert.fetch_success'));
    }
    public function store(CourseTestRequest $request, Course $course): JsonResponse
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;
        $this->courseTest->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param CourseTestRequest $request [explicite description]
     * @param CourseTest $courseTest [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseTestRequest $request, CourseTest $courseTest): JsonResponse
    {
        $this->courseTest->update($courseTest->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param CourseTest $courseTest [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(CourseTest $courseTest): JsonResponse
    {
        $this->courseTest->delete($courseTest->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
