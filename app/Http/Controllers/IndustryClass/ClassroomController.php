<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ClassroomInterface;
use App\Contracts\Interfaces\IndustryClass\SchoolInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndustryClass\ClassroomResource;
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
        $classrooms = $this->classroom->getWhere(['school' => $school->id]);
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
