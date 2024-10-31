<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\UserEventAttendanceInterface;
use App\Models\Event;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class UserEventAttendanceController extends Controller
{

    protected UserEventAttendanceInterface $userEventAttendance;
    public function __construct(UserEventAttendanceInterface $userEventAttendance)
    {
        $this->userEventAttendance = $userEventAttendance;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        dd($this->userEventAttendance->get($event));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserEventAttendance $userEventAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserEventAttendance $userEventAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserEventAttendance $userEventAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserEventAttendance $userEventAttendance)
    {
        //
    }
}
