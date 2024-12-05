<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AttendanceInterface;
use App\Contracts\Interfaces\IndustryClass\AttendanceStudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\AttendanceStudentResource;
use App\Models\Attendance;
use App\Services\IndustryClass\AttendanceService;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use PaginationTrait;
    private AttendanceStudentInterface $attendanceStudent;
    private AttendanceInterface $attendance;
    private AttendanceService $service;

    public function __construct(AttendanceStudentInterface $attendanceStudent, AttendanceInterface $attendance, AttendanceService $service)
    {
        $this->attendanceStudent = $attendanceStudent;
        $this->attendance = $attendance;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $attendances = $this->attendance->paginateAttendance($request, auth()->user()->id);
            $data['paginate'] = $this->customPaginate($attendances->currentPage(), $attendances->lastPage());
            $data['data'] = AttendanceResource::collection($attendances);
        } else {
            $attendances = $this->attendance->paginateAttendance($request, auth()->user()->id);
            $data['data'] = AttendanceResource::collection($attendances);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        try {
            $data = $this->service->store($request);
            $this->attendance->store($data);
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.add_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $attendance = $this->attendance->showWithSlug($slug);
            $attendanceStudents = $this->attendanceStudent->getWhere(['attendance_id' => $attendance->id]);
            return ResponseHelper::success(AttendanceStudentResource::collection($attendanceStudents), trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.fetch_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $this->attendance->update($attendance->id, ['status' => $attendance->status == true ? false : true]);
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        try {
            $data = $this->service->update($request);
            $this->attendance->update($attendance->id, $data);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        try {
            $this->attendance->delete($attendance->id);
            return ResponseHelper::success(null, trans('alert.delete_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.delete_failed'));
        }
    }
}
