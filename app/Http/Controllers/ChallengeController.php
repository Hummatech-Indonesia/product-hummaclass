<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ChallengeInterface;
use App\Http\Resources\ChallengeResource;
use App\Http\Requests\ChallengeRequest;
use App\Services\ChallengeService;
use App\Helpers\ResponseHelper;
use App\Models\Challenge;

class ChallengeController extends Controller
{
    private ChallengeInterface $challenge;
    private ChallengeService $service;

    public function __construct(ChallengeInterface $challenge, ChallengeService $service)
    {
        $this->challenge = $challenge;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $challenges = $this->challenge->get();
            return ResponseHelper::success(ChallengeResource::collection($challenges), trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.fetch_failed'));
        }
    }
    
    public function getByClassroom(string $studentSlug)
    {
        $challenges = $this->challenge->getByClassroom($studentSlug);
        return ResponseHelper::success(ChallengeResource::collection($challenges), trans('alert.fetch_success'));
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
    public function show(string $id)
    {
        //
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
            $data = $this->service->store($request);
            $this->challenge->update($challenge->id, $data);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
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
            $folderPath = public_path('storage/challenge/'. $challenge->slug);
            $zipFilePath = storage_path("app/public/{$challenge->slug}.zip");
            $this->service->download_zip($folderPath, $zipFilePath);
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            return ResponseHelper::error(null, trans('alert.download_failed'));
        }
    }
}