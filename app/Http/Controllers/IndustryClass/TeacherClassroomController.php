<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\TeacherClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherClassroomRequest;
use App\Http\Resources\TeacherClassroomResource;
use App\Models\TeacherClassroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherClassroomController extends Controller
{
    private TeacherClassroomInterface $teacherClassroom;
    public function __construct(TeacherClassroomInterface $teacherClassroom)
    {
        $this->teacherClassroom = $teacherClassroom;
    }
    public function index(): JsonResponse
    {
        $teacherClassrooms = $this->teacherClassroom->get();
        return ResponseHelper::success(TeacherClassroomResource::collection($teacherClassrooms), trans('alert.fetch_success'));
    }
    public function store(TeacherClassroomRequest $request): JsonResponse
    {
        $this->teacherClassroom->store($request->validated());
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
    public function show(TeacherClassroom $teacherClassroom): JsonResponse
    {
        return ResponseHelper::success(TeacherClassroomResource::make($teacherClassroom), trans('alert.fetch_success'));
    }
    public function update(TeacherClassroomRequest $request, TeacherClassroom $teacherClassroom): JsonResponse
    {
        $this->teacherClassroom->update($teacherClassroom->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
    public function destroy(TeacherClassroom $teacherClassroom): JsonResponse
    {
        try {
            $this->teacherClassroom->delete($teacherClassroom->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}

