<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryClass\SchoolRequest;
use App\Http\Resources\DetailSchoolResource;
use App\Http\Resources\IndustryClass\SchoolResource;
use App\Models\School;
use App\Services\IndustryClass\SchoolService;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    use PaginationTrait;
    private SchoolInterface $school;
    private SchoolService $service;

    public function __construct(SchoolInterface $school, SchoolService $service)
    {
        $this->school = $school;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schools = $this->school->customPaginate($request);
        $data['paginate'] = $this->customPaginate($schools->currentPage(), $schools->lastPage());
        $data['data'] = SchoolResource::collection($schools);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolRequest $request)
    {
        $this->school->store($this->service->store($request));

        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show(string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        return ResponseHelper::success(SchoolResource::make($school), trans('alert.fetch_success'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolRequest $request, School $school)
    {
        $this->school->update($school->id, $this->service->update($request, $school));
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        try {
            $this->school->delete($school->id);
            $this->service->remove($school->photo);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
