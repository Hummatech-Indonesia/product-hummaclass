<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Contracts\Interfaces\IndustryClass\TeacherInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private TeacherInterface $teacher;
    private SchoolInterface $school;
    public function __construct(TeacherInterface $teacher, SchoolInterface $school)
    {
        $this->teacher = $teacher;
        $this->school = $school;
    }
    public function index(string $slug): JsonResponse
    {
        $school = $this->school->showWithSlug($slug);
        $teachers = $this->teacher->getWhere(['school_id' => $school->id]);
        return ResponseHelper::success(TeacherResource::collection($teachers), trans('alert.fetch_success'));
    }
    public function store(TeacherRequest $request, School $school): JsonResponse
    {
        $data = $request->validated();
        $data['school_id'] = $school->id;
        $this->teacher->store($data);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
    public function show(Teacher $teacher): JsonResponse
    {
        return ResponseHelper::success(TeacherResource::make($teacher), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param TeacherRequest $request [explicite description]
     * @param Teacher $teacher [explicite description]
     *
     * @return JsonResponse
     */
    public function update(TeacherRequest $request, Teacher $teacher): JsonResponse
    {
        $this->teacher->update($teacher->id, $request->validated());
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