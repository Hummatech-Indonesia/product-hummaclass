<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModulInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\ModulRequest;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\ModulResource;
use App\Models\Course;
use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    private ModulInterface $modul;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(ModulInterface $modul)
    {
        $this->modul = $modul;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moduls = $this->modul->get();
        return ResponseHelper::success(ModulResource::collection($moduls));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ModulRequest $request)
    {
        $this->modul->store($request->validated());
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
    public function update(ModulRequest $request, Modul $modul)
    {
        $this->modul->update($modul->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        try {
            $this->modul->delete($modul->id);
            return ResponseHelper::success(trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::success(trans('alert.delete_constrained'));
        }
    }
}
