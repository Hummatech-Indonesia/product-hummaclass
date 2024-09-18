<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\EventInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
        return ResponseHelper::success($events, trans('alert.fetch_success'));
    }    
    /**
     * Method store
     *
     * @param EventRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(EventRequest $request): JsonResponse
    {
        $this->service->store($request);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }    
    /**
     * Method update
     *
     * @param EventRequest $request [explicite description]
     * @param Event $event [explicite description]
     *
     * @return JsonResponse
     */
    public function update(EventRequest $request, Event $event): JsonResponse
    {
        $this->service->update($request, $event);
        return ResponseHelper::success(true, trans('alert.update_success'));
    }    
    /**
     * Method delete
     *
     * @param Event $event [explicite description]
     *
     * @return JsonResponse
     */
    public function delete(Event $event): JsonResponse
    {
        $this->service->delete($event);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
