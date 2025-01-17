<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\EventInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Services\EventService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use PaginationTrait;
    private EventInterface $event;
    private EventService $service;
    public function __construct(EventInterface $event, EventService $service)
    {
        $this->event = $event;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $events = $this->event->customPaginate($request);
        $data['paginate'] = $this->customPaginate($events->currentPage(), $events->lastPage());
        $data['data'] = EventResource::collection($events);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * pageUser
     *
     * @return JsonResponse
     */
    public function pageUser(): JsonResponse
    {
        $events = $this->event->get();
        return ResponseHelper::success(EventResource::collection($events));
    }

    /**
     * Method store
     *
     * @param EventRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(EventRequest $request)
    {
        // return ($request->validated());
        $this->service->store($request);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param Event $event [explicite description]
     *
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $event = $this->event->showWithSlug($slug);
        return ResponseHelper::success(EventResource::make($event), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param EventRequest $request [explicite description]
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function update(EventRequest $request, string $slug): JsonResponse
    {
        $event = $this->event->showWithSlug($slug);
        $this->service->update($request, $event);
        return ResponseHelper::success(true, trans('alert.update_success'));
    }

    /**
     * Method destroy
     *
     * @param Event $event [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Event $event): JsonResponse
    {
        try {
            $this->service->delete($event);
        } catch (\Throwable $e) {
            return ResponseHelper::success(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }

    public function attendance(EventAttendance $eventAttendance, $date): JsonResponse
    {
        $this->service->attendance($eventAttendance);
        if ($this->service->isLastAttendance($eventAttendance) && $this->service->checkAttendance($eventAttendance)) {
            $this->service->setCertificateUser($eventAttendance->event);
        }
        return ResponseHelper::success(null, trans('alert.fetch_success'));
    }
}
