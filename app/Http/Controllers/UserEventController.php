<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserEventRepository;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreUserEventRequest;
use App\Http\Requests\UpdateUserEventRequest;
use App\Http\Resources\UserEventResource;
use App\Models\Event;
use App\Traits\PaginationTrait;

class UserEventController extends Controller
{
    use PaginationTrait;

    protected UserEventRepository $userEvent;
    public function __construct(UserEventRepository $userEvent)
    {
        $this->userEvent = $userEvent;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userEvents = $this->userEvent->customPaginate(null, 10);
        // dd($userEvents);
        $data['paginate'] = $this->customPaginate($userEvents->currentPage(), $userEvents->lastPage());
        $data['data'] = UserEventResource::collection($userEvents);
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
    public function store(StoreUserEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserEvent $userEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserEvent $userEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserEventRequest $request, UserEvent $userEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserEvent $userEvent)
    {
        //
    }

    public function checkPayment(Request $request)
    {
        // dd(auth()->user()->id, $request->event_slug);
        $event = Event::where('slug', $request->event_slug)->first();
        $userCourse = UserEvent::with('event')->where('user_id', auth()->user()->id)->whereRelation('event', 'slug', $request->event_slug)->first();
        if ($userCourse) {
            return ResponseHelper::success(['user_event' => $userCourse, 'event' => $event], 'Valid');
        } else {
            return ResponseHelper::error(['user_event' => $userCourse, 'event' => $event], 'Not valid');
        }
    }
}
