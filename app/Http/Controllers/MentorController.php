<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\MentorInterface;
use App\Helpers\ResponseHelper;
use App\Models\Mentor;
use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Resources\MentorResource;
use App\Services\MentorService;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MentorController extends Controller
{
    use PaginationTrait;
    private MentorInterface $mentor;
    private MentorService $service;

    public function __construct(MentorInterface $mentor, MentorService $service)
    {
        $this->mentor = $mentor;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentors = $this->mentor->get();
        return ResponseHelper::success(MentorResource::collection($mentors), trans('alert.fetch_success'));
    }

    public function getMentorAdmin(Request $request)
    {
        $mentors = $this->mentor->getMentorPaginate($request);
        $data['paginate'] = $this->customPaginate($mentors->currentPage(), $mentors->lastPage());
        $data['data'] = MentorResource::collection($mentors);
        return ResponseHelper::success($data);
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
    public function store(StoreMentorRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->service->store($request);
            $this->mentor->store($data);
            DB::commit();
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error($th, trans('alert.add_fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        $data = $this->mentor->show($mentor->id);
        return ResponseHelper::success(new MentorResource($data), trans('alert.fetch_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMentorRequest $request, Mentor $mentor)
    {
        DB::beginTransaction();
        try {
            $data = $this->service->update($request, $mentor);
            $this->mentor->update($mentor->id, $data);
            DB::commit();
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error($th, trans('alert.update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        DB::beginTransaction();
        try {
            $mentor->user->delete();
            $mentor->delete();
            DB::commit();
            return ResponseHelper::success(trans('alert.delete_success'));
        } catch (\Exception $th) {
            DB::rollBack();
            return ResponseHelper::error($th, trans('alert.delete_fail'));
        }
    }
}
