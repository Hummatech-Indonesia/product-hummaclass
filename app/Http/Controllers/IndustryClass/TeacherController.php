<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Interfaces\IndustryClass\TeacherInterface;
use App\Enums\RoleEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UpdateUserTeacherRequest;
use App\Http\Requests\UserTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use PaginationTrait;
    private TeacherInterface $teacher;
    private UserInterface $user;
    private SchoolInterface $school;
    public function __construct(TeacherInterface $teacher, SchoolInterface $school, UserInterface $user)
    {
        $this->teacher = $teacher;
        $this->user = $user;
        $this->school = $school;
    }
    public function index(Request $request, string $slug): JsonResponse
    {
        $school = $this->school->showWithSlug($slug);
        $request->merge(['school_id' => $school->id]);
        $teachers = $this->teacher->customPaginate($request);
        $data['paginate'] = $this->customPaginate($teachers->currentPage(), $teachers->lastPage());
        $data['data'] = TeacherResource::collection($teachers);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $school
     * @return JsonResponse
     */
    public function store(UserTeacherRequest $request, string $slug): JsonResponse
    {
        $school = $this->school->showWithSlug($slug);
        $data = $request->validated();
        $data['school_id'] = $school->id;
        $data['email_verified_at'] = now();
        $user = $this->user->store($data)->assignRole(RoleEnum::TEACHER->value);
        $data['user_id'] = $user->id;
        $this->teacher->store($data);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * show
     *
     * @param  mixed $teacher
     * @return JsonResponse
     */
    public function show(Teacher $teacher): JsonResponse
    {
        return ResponseHelper::success(TeacherResource::make($teacher), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param UpdateUserTeacherRequest $request [explicite description]
     * @param Teacher $teacher [explicite description]
     *
     * @return JsonResponse
     */
    public function update(UpdateUserTeacherRequest $request, Teacher $teacher): JsonResponse
    {
        $data = $request->validated();
        $this->user->customUpdate($teacher->user->id, $data);
        $this->teacher->update($teacher->id, $data);
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Teacher $teacher [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Teacher $teacher): JsonResponse
    {
        try {
            $this->teacher->delete($teacher->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
