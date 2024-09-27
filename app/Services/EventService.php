<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\UploadTrait;

class EventService implements ShouldHandleFileUpload
{
    private EventInterface $event;
    private EventDetailInterface $eventDetail;
    public function __construct(EventInterface $event, EventDetailInterface $eventDetail)
    {
        $this->event = $event;
        $this->eventDetail = $eventDetail;
    }

    use UploadTrait;

    /**
     * Method store
     *
     * @param EventRequest $request [explicite description]
     *
     * @return array
     */
    public function store(EventRequest $request): array|bool
    {
        dd($request);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload(UploadDiskEnum::EVENTS->value, $request->file('image'));
        }

        $event = $this->event->store($data);
        if ($request->has('start')) {
            foreach ($data['start'] as $index => $start) {
                $detailData = [
                    'event_id' => $event->id,
                    'start' => $start,
                    'user_id' => $data['user_id'][$index],
                    'end' => $data['end'][$index],
                    'session' => $data['session'][$index],
                ];
                $this->eventDetail->store($detailData);
            }
        }
        return true;
    }
    /**
     * Method update
     *
     * @param EventRequest $request [explicite description]
     * @param Event $event [explicite description]
     *
     * @return array
     */
    public function update(EventRequest $request, Event $event): array|bool
    {
        $data = $request->validated();
        $image = $event->image;
        if ($request->hasFile('image')) {
            if ($image) {
                $this->remove($image);
            }
            $data['image'] = $this->upload(UploadDiskEnum::EVENTS->value, $request->file('image'));
        }

        $this->event->update($event->id, $data);
        EventDetail::query()->where('event_id', $event->id)->delete();
        if ($request->has('start')) {
            foreach ($data['start'] as $index => $start) {
                $detailData = [
                    'event_id' => $event->id,
                    'start' => $start,
                    'end' => $data['end'][$index],
                    'session' => $data['session'][$index],
                    'user_id' => $data['user_id'][$index],
                ];
                $this->eventDetail->store($detailData);
            }
        }
        return true;
    }
    /**
     * Method delete
     *
     * @param Event $event [explicite description]
     *
     * @return bool
     */
    public function delete(Event $event): bool
    {
        if ($event->image) {
            $this->remove($event->image);
        }

        return $this->event->delete($event->id);
    }
}
