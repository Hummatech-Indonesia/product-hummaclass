<?php

namespace App\Services;

use Illuminate\Http\Request;

class UserCourseTestService
{
    /**
     * userLastStep
     *
     * @param  mixed $course
     * @param  mixed $subModule
     * @return void
     */
    public function search($query, Request $request)
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->whereRelation('user', 'name', 'LIKE', '%' . $request->search . '%');
        })->when($request->type, function ($query) use ($request) {
            $query->where('test_type', 'LIKE', '%' . $request->type . '%');
        })->get();
    }
}
