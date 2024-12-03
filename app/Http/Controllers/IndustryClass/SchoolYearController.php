<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolYearInterface;
use App\Enums\SchoolYearStatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndustryClass\SchoolYearResource;
use App\Models\SchoolYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    private SchoolYearInterface $schoolYear;

    public function __construct(SchoolYearInterface $schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $schoolYears = $this->schoolYear->get();
        return ResponseHelper::success(SchoolYearResource::collection($schoolYears));
    }

    /**
     * store
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $this->schoolYear->store();
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
    /**
     * Method destroy
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        try {

            $this->schoolYear->delete();
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_failed'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
