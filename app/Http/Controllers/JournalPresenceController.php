<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\JournalInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\JournalPresentRequest;
use App\Http\Requests\JournalRequest;
use App\Http\Requests\JournalUpdateRequest;
use App\Models\Journal;
use App\Services\IndustryClass\JournalPresenceService;
use App\Services\IndustryClass\JournalService;
use Illuminate\Http\Request;

class JournalPresenceController extends Controller
{
    private JournalInterface $journal;
    private JournalService $service;
    private JournalPresenceService $presenceService;

    public function __construct(JournalInterface $journal, JournalService $service, JournalPresenceService $presenceService)
    {
        $this->journal = $journal;
        $this->service = $service;
        $this->presenceService = $presenceService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JournalPresentRequest $request)
    {
        try {
            $data = $this->service->storeByTeacher($request);
            $journal = $this->journal->store($data);
            $this->presenceService->store($request['journal_presence'], $journal);
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::error($th, trans('alert.add_failed'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JournalUpdateRequest $request, Journal $journal)
    {
        try {
            $data = $this->service->update($request, $journal);
            $this->journal->update($journal->id, $data);
            $this->presenceService->update($request['journal_presence'], $journal);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
        }
    }
}
