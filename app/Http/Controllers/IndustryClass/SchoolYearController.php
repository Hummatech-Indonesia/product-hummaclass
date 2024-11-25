<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolYearInterface;
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
        return $this->schoolYear = $schoolYear;
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
        $schoolYear = $this->schoolYear->getLatest();
        $schoolYear = explode('/', $schoolYear->school_year);
        $newSchoolYear = intval($schoolYear[1]) . '/' . intval($schoolYear[1] + 1);
        $this->schoolYear->store(['school_year' => $newSchoolYear]);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * delete
     *
     * @param  mixed $schoolYear
     * @return void
     */
    public function delete(SchoolYear $schoolYear)
    {
        $this->schoolYear->delete($schoolYear->id);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
}
