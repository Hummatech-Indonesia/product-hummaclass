<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ChallengeInterface;
use App\Contracts\Interfaces\ChallengeSubmitInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Http\Resources\ChallengeResource;
use App\Http\Requests\ChallengeRequest;
use App\Services\ChallengeService;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ChallengeSubmitResource;
use App\Http\Resources\DetailChallengeResource;
use App\Models\Challenge;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    use PaginationTrait;
    private ChallengeInterface $challenge;
    private ChallengeSubmitInterface $challengeSubmit;
    private ChallengeService $service;
    private StudentInterface $student;

    public function __construct(ChallengeInterface $challenge, ChallengeService $service, ChallengeSubmitInterface $challengeSubmit, StudentInterface $student)
    {
        $this->challenge = $challenge;
        $this->service = $service;
        $this->challengeSubmit = $challengeSubmit;
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $challenges = $this->challenge->customPaginate($request);
            $data['paginate'] = $this->customPaginate($challenges->currentPage(), $challenges->lastPage());
            $data['data'] = ChallengeResource::collection($challenges);
        } else {
            $challenges = $this->challenge->customPaginate($request);
            $data['data'] = ChallengeResource::collection($challenges);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    public function getByClassroom(Request $request, string $studentSlug)
    {
        $student = $this->student->first(['user_id' => auth()->user()->id]);
        if ($request->has('page')) {
            $challenges = $this->challenge->getByClassroom($request, $studentSlug, ['student_id' => $student->id]);
            $data['paginate'] = $this->customPaginate($challenges->currentPage(), $challenges->lastPage());
            $data['data'] = ChallengeResource::collection($challenges);
        } else {
            $challenges = $this->challenge->getByClassroom($request, $studentSlug, ['student_id' => $student->id]);
            $data['data'] = ChallengeResource::collection($challenges);
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
    public function store(ChallengeRequest $request)
    {
        try {
            $data = $this->service->store($request);
            $this->challenge->store($data);
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.add_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $challenge = $this->challenge->showWithSlug($slug);
        return ResponseHelper::success(DetailChallengeResource::make($challenge), trans('alert.fetch_success'));
    }

    public function showChallengeSubmit(Request $request, Challenge $challenge)
    {
        if ($request->has('page')) {
            $challengeSubmits = $this->challengeSubmit->paginateSubmit($request, $challenge->id);
            $data['paginate'] = $this->customPaginate($challengeSubmits->currentPage(), $challengeSubmits->lastPage());
            $data['data'] = ChallengeSubmitResource::collection($challengeSubmits);
        } else {
            $challengeSubmits = $this->challengeSubmit->paginateSubmit($request, $challenge->id);
            $data['data'] = ChallengeSubmitResource::collection($challengeSubmits);
        }

        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChallengeRequest $request, Challenge $challenge)
    {
        try {
            $data = $this->service->update($request);
            $this->challenge->update($challenge->id, $data);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, trans('alert.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenge $challenge)
    {
        try {
            $this->challenge->delete($challenge->id);
            return ResponseHelper::success(null, trans('alert.delete_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.delete_failed'));
        }
    }

    public function download_zip(Challenge $challenge)
    {
        try {
            $folderPath = public_path('storage/challenge/' . $challenge->slug);
            $zipFilePath = storage_path("app/public/{$challenge->slug}.zip");
            $this->service->download_zip($folderPath, $zipFilePath);
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, trans('alert.download_failed'));
        }
    }
}
