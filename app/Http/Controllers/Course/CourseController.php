<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\Course\DetailCourseResource;
use App\Http\Resources\Course\ModuleResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\QuizResource;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\UserQuiz;
use App\Services\Course\CourseService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CourseController extends Controller
{
    use PaginationTrait;
    private CourseInterface $course;
    private UserCourseInterface $userCourse;
    private ModuleInterface $module;
    private CourseService $service;


    /**
     * Method __construct
     *
     * @param CourseInterface $course [explicite description]
     *
     * @return void
     */
    public function __construct(CourseInterface $course, CourseService $service, UserCourseInterface $userCourse, ModuleInterface $module)
    {
        $this->userCourse = $userCourse;
        $this->course = $course;
        $this->service = $service;
        $this->module = $module;
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->has('page')) {
            $courses = $this->course->customPaginate($request);
            $data['paginate'] = $this->customPaginate($courses->currentPage(), $courses->lastPage());
            $data['data'] = CourseResource::collection($courses);
        } else {
            $courses = $this->course->search($request);
            $data['data'] = CourseResource::collection($courses);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Method store
     *
     * @param CourseRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $this->course->store($this->service->store($request));
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        return ResponseHelper::success(DetailCourseResource::make($course), trans('alert.fetch_success'));
    }

    /**
     * Method update
     *
     * @param CourseRequest $request [explicite description]
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseRequest $request, Course $course): JsonResponse
    {
        $this->course->update($course->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        try {
            $this->course->delete($course->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(true, trans('alert.delete_constrained'));
        }
    }
    /**
     * Method readyToUse
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function readyToUse(Course $course): JsonResponse
    {
        $data = [
            'is_ready' => true
        ];
        $course = $this->course->update($course->id, $data);
        return ResponseHelper::success($course, trans('alert.update_success'));
    }
    /**
     * Method listCourse
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function listCourse(Request $request): JsonResponse
    {
        $request->merge(['is_ready' => true]);
        if ($request->has('page')) {
            $courses = $this->course->customPaginate($request);
            $data['paginate'] = $this->customPaginate($courses->currentPage(), $courses->lastPage());
            $data['data'] = CourseResource::collection($courses);
        } else {
            $courses = $this->course->search($request);
            $data['data'] = CourseResource::collection($courses);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    /**
     * Method share
     *
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function share(string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        return ResponseHelper::success(CourseResource::make($course), trans('alert.fetch_success'));
    }


    public function count(): JsonResponse
    {
        $course_count = $this->course->count();
        return ResponseHelper::success(['course_count' => $course_count], trans('alert.fetch_success'));
    }

    public function getBySubModule($subModule)
    {
        // return ResponseHelper::success($subModule);
        return ResponseHelper::success(Course::whereRelation('modules.subModules', 'slug', $subModule)->first());
    }

    /**
     * checkSubmit
     *
     * @return JsonResponse
     */
    public function checkSubmit(UserQuiz $userQuiz): JsonResponse
    {
        $quiz = $userQuiz->quiz->minimum_score;
        if ($userQuiz->score >= $quiz) {
            $userCourse = $this->userCourse->showByCourse($userQuiz->quiz->module->course_id);
            $module_step = 1;
            foreach ($userCourse->course->modules as $module) {
                if ($module->step > $module_step) {
                    $module_step = $module->step;
                }
            }
            $module = $this->module->whereStepCourse($module_step, $userCourse->course->id);
            if ($userQuiz->quiz->module->id == $module->id) {
                $data['status'] = 'finished';
                $data['parameter'] = $userQuiz->quiz->module->course->courseTest->id;
            } else {
                $data['status'] = 'not_finished';
                $data['parameter'] = $userQuiz->quiz->module->slug;
            }
        } else {
            $data['status'] = 'not_finished';
            $data['parameter'] = $userQuiz->quiz->module->slug;
        }
        $data['course'] = CourseResource::make($userQuiz->quiz->module->course);
        return ResponseHelper::success($data);
    }
}
