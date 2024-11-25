<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\EventCertivicateResource;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\UserCourse;
use App\Services\CertificateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    private CertificateInterface $certificate;
    private UserCourseInterface $userCourse;
    private UserEventInterface $userEvent;
    private CourseInterface $course;
    private EventInterface $event;
    private CertificateService $service;
    public function __construct(CertificateInterface $certificate, CourseInterface $course, UserCourseInterface $userCourse, CertificateService $service, EventInterface $event, UserEventInterface $userEvent)
    {
        $this->certificate = $certificate;
        $this->course = $course;
        $this->event = $event;
        $this->userCourse = $userCourse;
        $this->userEvent = $userEvent;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function show(string $type, $slug): mixed
    {
        if ($type == 'course') {
            $course = $this->course->showWithSlugWithoutRequest($slug);
            $userCourse = $this->userCourse->showByCourse($course->id);
            $certificate = $this->certificate->showWithCourse($userCourse->id);
            return ResponseHelper::success(CertificateResource::make($certificate), trans('alert.fetch_success'));
        } else {
            $event = $this->event->showWithSlug($slug);
            $userEvent = $this->userEvent->showByEvent(auth()->user()->id, $event->id);
            $certificate = $this->certificate->showWithEvent($userEvent->id);
            return ResponseHelper::success(EventCertivicateResource::make($certificate), trans('alert.fetch_success'));
        }
    }
    /**
     * Method store
     *
     * @param CertificateRequest $request [explicite description]
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CertificateRequest $request, $type, string $slug): mixed
    {
        if ($type == 'course') {
            $this->service->store($request, $slug);
        } else {
            $this->service->storeEvent($request, $slug);
        }
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param CertificateRequest $request [explicite description]
     * @param Certificate $certificate [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CertificateRequest $request, Certificate $certificate): JsonResponse
    {
        try {
            UserCourse::where([
                'user_id' => auth()->user()->id,
                'has_downloaded' => false
            ])->firstOrFail();
            $this->certificate->update($certificate->id, $request->validated());
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.update_failed'));
        }
    }
    public function download($type, string $slug, string $user_id)
    {
        $certificate = $this->service->download($type, $slug, $user_id);

        // if ($type == 'course') return $certificate['pdf']->download($certificate['userCourse']->course->title . ' - ' . $certificate['userCourse']->certificate->username . '.pdf');
        // else return $certificate['pdf']->download($certificate['userEvent']->event->title . ' - ' . $certificate['userEvent']->certificate->username . '.pdf');

        return $certificate['pdf'];
    }
}
