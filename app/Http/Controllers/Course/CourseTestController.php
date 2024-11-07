<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseTestInterface;
use App\Contracts\Interfaces\Course\CourseTestQuestionInterface;
use App\Contracts\Interfaces\Course\ModuleQuestionInterface;
use App\Contracts\Interfaces\UserCourseTestInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTestRequest;
use App\Http\Requests\CustomCourseTestRequest;
use App\Http\Requests\UserCourseTestRequest;
use App\Http\Resources\CourseTestResource;
use App\Http\Resources\CourseTestResultResource;
use App\Http\Resources\ModuleQuestionResource;
use App\Http\Resources\UserCourseTestResource;
use App\Models\Course;
use App\Models\CourseTest;
use App\Models\UserCourseTest;
use App\Models\UserQuiz;
use App\Services\CourseTestService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseTestController extends Controller
{
    use PaginationTrait;
    private CourseTestInterface $courseTest;
    private CourseTestQuestionInterface $courseTestQuestion;
    private CourseInterface $course;
    private UserCourseTestInterface $userCourseTest;
    private ModuleQuestionInterface $moduleQuestion;
    private CourseTestService $service;
    public function __construct(CourseTestInterface $courseTest, CourseTestService $service, UserCourseTestInterface $userCourseTest, ModuleQuestionInterface $moduleQuestion, CourseInterface $course, CourseTestQuestionInterface $courseTestQuestion)
    {
        $this->courseTest = $courseTest;
        $this->course = $course;
        $this->userCourseTest = $userCourseTest;
        $this->moduleQuestion = $moduleQuestion;
        $this->courseTestQuestion = $courseTestQuestion;
        $this->service = $service;
    }
    public function index(string $slug, Request $request): JsonResponse
    {
        $course = $this->course->showWithSlug($request, $slug);
        $courseTest = $this->courseTest->show($course->id);
        if ($courseTest == null) return ResponseHelper::error(null, "Anda Belum Setting Test");
        return ResponseHelper::success(CourseTestResource::make($courseTest), trans('alert.fetch_success'));
    }

    /**
     * show
     *
     * @param  mixed $request
     * @param  mixed $courseTest
     * @return JsonResponse
     */
    public function show(Request $request, CourseTest $courseTest): JsonResponse
    {
        $this->service->store($courseTest);
        $request->merge(['course_id' => $courseTest->id]);
        $userCourseTests = $this->userCourseTest->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userCourseTests->currentPage(), $userCourseTests->lastPage());
        $data['data'] = UserCourseTestResource::collection($userCourseTests);
        return responsehelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * get
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $courseTests = $this->courseTest->get();
        return ResponseHelper::success(CourseTestResource::collection($courseTests), trans('alert.fetch_success'));
    }

    /**
     * Method preTest
     *
     * @param CourseTest $courseTest [explicite description]
     *
     * @return JsonResponse
     */
    public function preTest(CourseTest $courseTest, Request $request): JsonResponse
    {
        $preTest = $this->service->preTest($courseTest);
        if ($preTest == 'samean sampun ngrampungaken pre-test') {
            return ResponseHelper::error(null, trans('alert.fetch_failed'));
        }
        $request->merge(['id' => $preTest['questions']]);
        $questions = $this->moduleQuestion->customPaginate($request);
        $data['paginate'] = $this->customPaginate($questions->currentPage(), $questions->lastPage());
        $data['data'] = ModuleQuestionResource::collection($questions);
        $data['user_quiz'] = UserCourseTestResource::make($preTest['preTest']);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * postTest
     *
     * @param  mixed $request
     * @param  mixed $courseTest
     * @return JsonResponse
     */
    public function postTest(Request $request, CourseTest $courseTest): JsonResponse
    {
        try {
            $postTest = $this->service->postTest($courseTest);
            if ($postTest == 'already') {
                return ResponseHelper::error(null, trans('alert.fetch_failed'));
            }
            $request->merge(['id' => $postTest['questions']]);
            $questions = $this->moduleQuestion->customPaginate($request);
            $data['paginate'] = $this->customPaginate($questions->currentPage(), $questions->lastPage());
            $data['data'] = ModuleQuestionResource::collection($questions);
            $data['course_test'] = CourseTestResource::make($courseTest);
            $data['user_quiz'] = UserCourseTestResource::make($postTest['postTest']);
            return ResponseHelper::success($data, trans('alert.fetch_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.not_pre_test_yet'));
        }
    }

    /**
     * submit
     *
     * @param  mixed $request
     * @param  mixed $userCourseTest
     * @return JsonResponse
     */
    public function submit(UserCourseTestRequest $request, UserCourseTest $userCourseTest): JsonResponse
    {
        $this->service->submit($request, $userCourseTest);
        return ResponseHelper::success(null, trans('alert.fetch_success'));
    }
    public function statistic(userCourseTest $userCourseTest): JsonResponse
    {
        $result = $this->userCourseTest->show($userCourseTest->id);
        return ResponseHelper::success(CourseTestResultResource::make($result), trans('alert.fetch_success'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $slug
     * @return JsonResponse
     */
    public function store(CourseTestRequest $request, string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        $data = $request->validated();
        $data['course_id'] = $course->id;
        $courseTest = $this->courseTest->store($data);
        $courseTest->courseTestQuestions()->delete();

        foreach ($request['question_count'] as $index => $questionCount) {
            $storeData = [
                'course_test_id' => $courseTest->id,
                'question_count' => $questionCount,
                'module_id' => $data['module_id'][$index]
            ];
            $this->courseTestQuestion->store($storeData);
        }

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
