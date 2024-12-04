<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\JournalInterface;
use App\Services\IndustryClass\JournalService;
use App\Http\Requests\JournalRequest;
use App\Helpers\ResponseHelper;
use App\Http\Resources\JournalResource;
use Illuminate\Http\Request;
use App\Models\Journal;

class JournalController extends Controller
{
    private JournalInterface $journal;
    private JournalService $service;

    public function __construct(JournalInterface $journal, JournalService $service)
    {
        $this->journal = $journal;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $journals = $this->journal->search(['user_id' => auth()->user()->id], $request);
            return ResponseHelper::success(JournalResource::collection($journals), trans('alert.fetch_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.fetch_failed'));
        }
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
    public function store(JournalRequest $request)
    {
        try {
            $data = $this->service->store($request);
            $this->journal->store($data);
            return ResponseHelper::success(null, trans('alert.add_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.add_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JournalRequest $request, Journal $journal)
    {
        try {
            $data = $this->service->update($request, $journal);
            $this->journal->update($journal->id, $data);
            return ResponseHelper::success(null, trans('alert.update_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        try {
            $this->service->delete($journal);
            $this->journal->delete($journal->id);
            return ResponseHelper::success(null, trans('alert.delete_success'));
        } catch (\Throwable $th) {
            return ResponseHelper::success(null, trans('alert.delete_failed'));
        }
    }
}
