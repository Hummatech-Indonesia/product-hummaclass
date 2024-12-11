<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ChallengeSubmitInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ChallengeSubmitRequest;
use App\Http\Requests\PointChallengeSubmitRequest;
use App\Http\Resources\ChallengeSubmitResource;
use App\Models\Challenge;
use App\Models\ChallengeSubmit;
use App\Models\Classroom;
use App\Models\User;
use App\Services\ChallengeSubmitService;
use Illuminate\Http\Request;

class ChallengeSubmitController extends Controller
{
    private ChallengeSubmitInterface $challengeSubmit;
    private ChallengeSubmitService $service;

    public function __construct(ChallengeSubmitInterface $challengeSubmit, ChallengeSubmitService $service)
    {
        $this->challengeSubmit = $challengeSubmit;  
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Challenge $challenge)
    {
        try {
            $challengeSubmits = $this->challengeSubmit->getByStudent(['user_id' => auth()->user()->id, 'challenge_id' => $challenge->id]);
            return ResponseHelper::success(ChallengeSubmitResource::collection($challengeSubmits), trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.fetch_failed'));
        }
    }

    public function add_point(PointChallengeSubmitRequest $request, Challenge $challenge)
    {
        $this->service->add_point($request, $challenge);
        return ResponseHelper::success(null, trans('alert.update_success'));
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
    public function store(ChallengeSubmitRequest $request, Challenge $challenge)
    {
        // try {
            $data = $this->service->store($request, $challenge);
            $this->challengeSubmit->store($data);
            return ResponseHelper::success(null, trans('alert.add_success'));
        // } catch (\Throwable $th) {
        //     return ResponseHelper::success(null, trans('alert.add_failed'));
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(ChallengeSubmit $challengeSubmit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChallengeSubmit $challengeSubmit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChallengeSubmitRequest $request, ChallengeSubmit $challengeSubmit)
    {
        try {
            $data = $this->service->update($request, $challengeSubmit);
            $this->challengeSubmit->update($challengeSubmit->id, $data);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChallengeSubmit $challengeSubmit)
    {
        try {
            $this->service->delete($challengeSubmit);
            $this->challengeSubmit->delete($challengeSubmit->id);
            return ResponseHelper::success(null, trans('alert.delete_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.delete_failed'));
        }
    }
}
