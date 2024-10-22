<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CertificateInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
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
        $certificates = $this->certificate->getWhere(['user_course_id.user_id' => auth()->user()->id]);
        return ResponseHelper::success(CertificateResource::collection($certificates), trans('alert.fetch_success'));
    }    
    /**
     * Method store
     *
     * @param CertificateRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CertificateRequest $request): JsonResponse
    {
        $this->certificate->store($request->validated());
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
