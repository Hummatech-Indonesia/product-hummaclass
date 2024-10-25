<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
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
    private CourseInterface $course;
    private CertificateService $service;
    public function __construct(CertificateInterface $certificate, CourseInterface $course, UserCourseInterface $userCourse, CertificateService $service)
    {
        $this->certificate = $certificate;
        $this->course = $course;
        $this->userCourse = $userCourse;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);
        $userCourse = $this->userCourse->showByUserCourse($course->id);
        $certificate = $this->certificate->showWithCourse($userCourse->id);
        return ResponseHelper::success(CertificateResource::make($certificate), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param CertificateRequest $request [explicite description]
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CertificateRequest $request, string $slug): JsonResponse
    {
        $this->service->store($request, $slug);
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
    public function download(string $slug, string $user_id)
    {
        $certificate = $this->service->download($slug, $user_id);


        return $certificate['pdf']->download($certificate['userCourse']->course->title . ' - ' . $certificate['userCourse']->certificate->username . '.pdf');
    }
}
