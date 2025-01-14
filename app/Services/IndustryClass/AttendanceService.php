<?php

namespace App\Services\IndustryClass;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;

class AttendanceService
{
    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(AttendanceRequest $request): array|bool
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $school
     * @return array
     */
    public function update(AttendanceRequest $request): array|bool
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
}
