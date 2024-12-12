<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Contracts\Interfaces\IndustryClass\ZoomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ZoomRequest;
use App\Http\Resources\ZoomResource;
use App\Models\Zoom;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomController extends Controller
{
    use PaginationTrait;
    private ZoomInterface $zoom;
    private StudentInterface $student;

    public function __construct(ZoomInterface $zoom, StudentInterface $student)
    {
        $this->zoom = $zoom;
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('page')) {
            $zooms = $this->zoom->customPaginate($request);
            $data['paginate'] = $this->customPaginate($zooms->currentPage(), $zooms->lastPage());
            $data['data'] = ZoomResource::collection($zooms);
        } else {
            $zooms = $this->zoom->customPaginate($request);
            $data['data'] = ZoomResource::collection($zooms);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ZoomRequest $request): JsonResponse
    {
        try {
            $this->zoom->store($request->validated());
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.add_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $student = $this->student->first(['user_id' => auth()->user()->id]);
            $zooms = $this->zoom->getWhere(['classroom_id' => $student->studentClassrooms()->latest()->first()->classroom_id]);
            return ResponseHelper::success(ZoomResource::collection($zooms), trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, trans('alert.fetch_failed') . " error: " . $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zoom $zoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ZoomRequest $request, Zoom $zoom): JsonResponse
    {
        try {
            $this->zoom->update($zoom->id, $request->validated());
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zoom $zoom): JsonResponse
    {
        try {
            $this->zoom->delete($zoom->id);
            return ResponseHelper::success(null, trans('alert.delete_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.delete_failed'));
        }
    }
}
