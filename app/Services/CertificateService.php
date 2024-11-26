<?php

namespace App\Services;

use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\UserCourse;
use App\Models\UserEvent;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateService
{
    private CertificateInterface $certificate;
    private CourseInterface $course;
    private EventInterface $event;
    public function __construct(CertificateInterface $certificate, CourseInterface $course, EventInterface $event)
    {
        $this->certificate = $certificate;
        $this->course = $course;
        $this->event = $event;
    }
    public function store(CertificateRequest $request, string $slug)
    {
        $data = $request->validated();

        $course = $this->course->showWithSlugWithoutRequest($slug);

        $userCourse = UserCourse::where([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id
        ])->firstOrFail();

        $data['user_course_id'] = $userCourse->id;
        $data['user_event_id'] = null;

        $certificates = Certificate::count();
        $data['code'] = '12' . date('Ymd') . str_pad($certificates + 1, 4, '0', STR_PAD_LEFT);

        $this->certificate->store($data);
        return true;
    }
    public function storeEvent(CertificateRequest $request, string $slug)
    {
        $data = $request->validated();

        $event = $this->event->showWithSlug($slug);

        $userEvent = UserEvent::where([
            'user_id' => auth()->user()->id,
            'event_id' => $event->id
        ])->firstOrFail();


        $data['user_event_id'] = $userEvent->id;
        $data['user_course_id'] = null;

        $certificates = Certificate::count();
        $data['code'] = '12' . date('Ymd') . str_pad($certificates + 1, 4, '0', STR_PAD_LEFT);

        $this->certificate->store($data);
        return true;
    }

    public function download($type, string $slug, string $user_id)
    {
        if ($type == 'courses') {
            $course = $this->course->showWithSlugWithoutRequest($slug);
            $userCourse = UserCourse::query()
                ->where([
                    'course_id' => $course->id,
                    'user_id' => $user_id,
                ])
                ->firstOrFail();
            $userCourse->update(['has_downloaded' => 1]);

            $pdf = Pdf::loadView('certificate', compact('userCourse', 'type', 'slug'))->setPaper('A4', 'landscape');
            return [
                'pdf' => $pdf,
                'userCourse' => $userCourse
            ];
        } else {
            $event = $this->event->showWithSlug($slug);
            $userEvent = UserEvent::query()
                ->where([
                    'event_id' => $event->id,
                    'user_id' => $user_id,
                ])
                ->firstOrFail();
            $userEvent->update(['has_downloaded' => 1]);
            $pdf = Pdf::loadView('certificate', compact('userEvent'))->setPaper('A4', 'landscape');
            return [
                'pdf' => $pdf,
                'userEvent' => $userEvent
            ];
        }
    }
}
