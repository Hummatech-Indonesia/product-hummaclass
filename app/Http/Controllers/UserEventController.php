<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Repositories\UserEventRepository;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreUserEventRequest;
use App\Http\Requests\UpdateUserEventRequest;
use App\Http\Resources\UserEventAdminResource;
use App\Http\Resources\UserEventResource;
use App\Models\Event;
use App\Traits\PaginationTrait;

class UserEventController extends Controller
{
    use PaginationTrait;

    private UserEventInterface $userEvent;
    private EventInterface $event;
    public function __construct(UserEventInterface $userEvent, EventInterface $event)
    {
        $this->userEvent = $userEvent;
        $this->event = $event;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userEvents = $this->userEvent->customPaginate($request, 10);
        $data['paginate'] = $this->customPaginate($userEvents->currentPage(), $userEvents->lastPage());
        $data['data'] = UserEventResource::collection($userEvents);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $event = $this->event->showWithSlug($slug);
        $request->merge(['event_id' => $event->id]);
        $userEvents = $this->userEvent->customPaginate($request, 10);
        $data['paginate'] = $this->customPaginate($userEvents->currentPage(), $userEvents->lastPage());
        $data['data'] = UserEventAdminResource::collection($userEvents);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * checkPayment
     *
     * @param  mixed $request
     * @return void
     */
    public function checkPayment(Request $request)
    {
        // dd(auth()->user()->id, $request->event_slug);
        // return $request;
        $event = Event::where('slug', $request->event_slug)->first();
        $userCourse = UserEvent::with('event')->where('user_id', auth()->user()->id)->whereRelation('event', 'slug', $request->event_slug)->first();
        if ($userCourse) {
            return ResponseHelper::success(['user_event' => $userCourse, 'event' => $event], 'Valid');
        } else {
            return ResponseHelper::error(['user_event' => $userCourse, 'event' => $event], 'Not valid');
        }
    }

    public function setCertificate(string $userEventId): mixed
    {
        try {
            $updated = $this->userEvent->update($userEventId, ['has_certificate' => true]);
            if ($updated) {
                return ResponseHelper::success(null, "Sertifikat berhasil ditetapkan");
            } else {
                return ResponseHelper::error(null, "Sertifikat gagal ditetapkan");
            }
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, $th->getMessage());
        }
    }
}
