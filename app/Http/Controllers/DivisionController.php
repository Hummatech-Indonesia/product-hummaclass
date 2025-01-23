<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\DivisionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    private DivisionInterface $division;
    public function __construct(DivisionInterface $division)
    {
        $this->division = $division;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $divisions = $this->division->search($request);
        return ResponseHelper::success(DivisionResource::collection($divisions), trans('alert.fetch_success'));
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
    public function store(DivisionRequest $request)
    {
        $this->division->store($request->validated());
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        return ResponseHelper::success(DivisionResource::make($division), trans('alert.fetch_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisionRequest $request, Division $division)
    {
        $this->division->update($division->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        try {
            $this->division->delete($division->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
