<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\UserCourse;
use App\Services\CertificateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    private CertificateInterface $certificate;
    private CertificateService $service;
    private CourseInterface $course;
    public function __construct(CertificateInterface $certificate, CourseInterface $course, CertificateService $service)
    {
        $this->certificate = $certificate;
        $this->course = $course;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $certificates = $this->certificate->get();
        return ResponseHelper::success(CertificateResource::collection($certificates), trans('alert.fetch_success'));
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
        $service = $this->service->store($request, $slug);
        if ($service === false) {
            return ResponseHelper::error(null, trans('alert.fetch_failed'));
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

        $this->certificate->update($certificate->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
