<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryClass\ClassroomRequest;
use App\Http\Resources\IndustryClass\ClassroomResource;
use App\Models\Classroom;
use App\Models\School;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    use PaginationTrait;
    private ClassroomInterface $classroom;
    private SchoolInterface $school;

    public function __construct(ClassroomInterface $classroom, SchoolInterface $school)
    {
        $this->classroom = $classroom;
        $this->school = $school;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $slug)
    {
        $school = $this->school->showWithSlug($slug);
        $classrooms = $this->classroom->getWhere(['school_id' => $school->id]);
        return ResponseHelper::success(ClassroomResource::collection($classrooms));
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
    public function store(ClassroomRequest $request, School $school)
    {
        $data = $request->validated();
        $data['school_id'] = $school->id;
        $this->classroom->store($data);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return ResponseHelper::success(ClassroomResource::make($classroom), trans('alert.fetch_success'));
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
    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $this->classroom->update($classroom->id, $request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        try {
            $this->classroom->delete($classroom->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
