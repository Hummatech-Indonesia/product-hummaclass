<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CertificateInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    private CertificateInterface $certificate;
    public function __construct(CertificateInterface $certificate)
    {
        $this->certificate = $certificate;
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
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CertificateRequest $request, Course $course): JsonResponse
    {
        $data = $request->validated();
        $userCourse = UserCourse::where([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id
        ])->firstOrFail();
        $certificates = Certificate::count();
        $data['user_course_id'] = $userCourse->id;
        $data['code'] = '12' . date('Ymd') . str_pad($certificates + 1, 4, '0', STR_PAD_LEFT);
        $this->certificate->store($data);
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
