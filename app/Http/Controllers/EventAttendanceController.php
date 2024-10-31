<?php

namespace App\Http\Controllers;

use App\Base\Interfaces\EventAttendanceInterface;
use App\Contracts\Interfaces\EventAttendanceInterface as InterfacesEventAttendanceInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\EventAttendanceRequest;
use App\Models\Event;
use App\Models\EventAttendance;
use Illuminate\Http\Request;

class EventAttendanceController extends Controller
{

    protected InterfacesEventAttendanceInterface $eventAtetndance;

    public function __construct(InterfacesEventAttendanceInterface $eventAtetndance) {
        $this->eventAtetndance = $eventAtetndance;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Event $event)
    {
        $eventAttendances = $this->eventAtetndance->get($request, $event);
        return ResponseHelper::success($eventAttendances, trans('alert.fetch_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventAttendanceRequest $request)
    {
        $created = $this->eventAtetndance->store($request->all());
        if($created) {
            return ResponseHelper::success(null, trans('alert.add_success'));
        }
        return ResponseHelper::error(null, trans('alert.add_failed'));
    }

    /**
     * Display the specified resource.
     */
    public function show(EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventAttendance $eventAttendance)
    {
        //
    }
}
