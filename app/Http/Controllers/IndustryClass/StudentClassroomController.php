<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\StudentClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndustryClass\StudentClassroomResource;
use App\Models\Classroom;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentClassroomController extends Controller
{
    use PaginationTrait;
    private StudentClassroomInterface $studentClassroom;
    public function __construct(StudentClassroomInterface $studentClassroom)
    {
        $this->studentClassroom = $studentClassroom;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function byClassroom(Request $request, Classroom $classroom): JsonResponse
    {
        $request->merge(['classroom_id' => $classroom->id]);
        $studentClassrooms = $this->studentClassroom->customPaginate($request);
        $data['paginate'] = $this->customPaginate($studentClassrooms->currentPage(), $studentClassrooms->lastPage());
        $data['data'] = StudentClassroomResource::collection($studentClassrooms);
        return ResponseHelper::success($data);
    }
}