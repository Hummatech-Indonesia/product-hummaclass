<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AttendanceInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Services\IndustryClass\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private AttendanceInterface $attendance;
    private AttendanceService $service;

    public function __construct(AttendanceInterface $attendance, AttendanceService $service)
    {
        $this->attendance = $attendance;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
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