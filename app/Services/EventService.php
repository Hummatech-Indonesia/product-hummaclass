<?php

namespace App\Services;

use App\Contracts\Interfaces\EventAttendanceInterface;
use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\UserEventAttendanceInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\EventDetail;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserEventAttendance;
use App\Traits\UploadTrait;
use Carbon\Carbon;

class EventService implements ShouldHandleFileUpload
{
    private EventInterface $event;
    private EventDetailInterface $eventDetail;
    private EventAttendanceInterface $eventAttendance;
    private UserEventAttendanceInterface $userEventAttendance;
    private UserEventInterface $userEvent;
    public function __construct(EventInterface $event, EventDetailInterface $eventDetail, EventAttendanceInterface $eventAttendance, UserEventAttendanceInterface $userEventAttendance, UserEventInterface $userEvent)
    {
        $this->event = $event;
        $this->userEvent = $userEvent;
        $this->eventDetail = $eventDetail;
        $this->eventAttendance = $eventAttendance;
        $this->userEventAttendance = $userEventAttendance;
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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload(UploadDiskEnum::EVENTS->value, $request->file('image'));
        }

        $event = $this->event->store($data);


        $start = Carbon::parse($event->start_date);
        $end = Carbon::parse($event->end_date);

        $diff = $start->diffInDays($end);

        for ($i = 0; $i <= $diff; $i++) {
            $attendanceData = [
                'event_id' => $event->id,
                'attendance_date' => $start->copy()->addDays($i),
                'attendance_link' => ""
            ];
            $eventAttendance = $this->eventAttendance->store($attendanceData);
            $eventAttendance->attendance_link = route('event-attendance.store', ['date' => $attendanceData['attendance_date'], 'event_attendance' => $eventAttendance->id]);
            $eventAttendance->save();
        }


        foreach ($data['start'] as $index => $start) {
            $detailData = [
                'event_id' => $event->id,
                'user' => $data['user'][$index],
                'event_date' => $data['event_date'][$index],
                'start' => $start,
                'end' => $data['end'][$index],
                'session' => $data['session'][$index],
            ];
            $this->eventDetail->store($detailData);
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
                    'user' => $data['user'][$index],
                    'event_date' => $data['event_date'][$index],
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
    public function attendance(EventAttendance $eventAttendance)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'event_attendance_id' => $eventAttendance->id,
            'is_attendance' => true
        ];
        $this->userEventAttendance->store($data);
    }
    public function checkAttendance(EventAttendance $eventAttendance)
    {
        $userId = auth()->user()->id;
        $eventAttendances = $eventAttendance->event->eventAttendances;
        $userAttendances = [];
        $complete = true;

        foreach ($eventAttendances as $attendance) {
            $count = UserEventAttendance::where([
                'user_id' => $userId,
                'event_attendance_id' => $attendance->id
            ])->count();

            $userAttendances[$attendance->id] = $count;
            $complete = $userAttendances[$attendance->id] == 1 ? true : false;
        }

        return $complete;
    }

    public function isLastAttendance(EventAttendance $eventAttendance)
    {
        $event = $eventAttendance->event;
        $lastAttendance = EventAttendance::where('event_id', $event->id)->orderBy('attendance_date', 'DESC')->first();

        return $eventAttendance->id == $lastAttendance->id;
    }

    public function setCertificateUser(Event $event)
    {
        $userEvent = UserEvent::where('event_id', $event->id)->where('user_id', auth()->user()->id)->first()->id;
        $this->userEvent->update($userEvent, ['has_certificate' => true]);
    }
}
