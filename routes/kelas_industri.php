<?php

use App\Http\Controllers\DivisionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryClass\SchoolController;
use App\Http\Controllers\IndustryClass\StudentController;
use App\Http\Controllers\IndustryClass\ClassroomController;
use App\Http\Controllers\IndustryClass\SchoolYearController;
use App\Http\Controllers\IndustryClass\StudentClassroomController;
use App\Http\Controllers\IndustryClass\TeacherController;



Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['is_admin'])->group(function () {

        // school
        Route::resource('schools', SchoolController::class)->only(['index', 'store', 'update', 'delete']);
        Route::get('schools/{slug}', [SchoolController::class, 'show']);

        // division
        Route::resource('divisions', DivisionController::class);

        // classroom
        Route::get('classrooms/{slug}', [ClassroomController::class, 'index']);
        Route::post('classrooms/{school}', [ClassroomController::class, 'store']);
        Route::get('classroom-detail/{classroom}', [ClassroomController::class, 'show']);
        Route::resource('classrooms', ClassroomController::class)->only(['update', 'destroy']);

        //school year
        Route::resource('school-years', SchoolYearController::class);

        // student
        Route::get('students/{slug}', [StudentController::class, 'index']);
        Route::post('students/{school}', [StudentController::class, 'store']);
        Route::get('student-detail/{student}', [StudentController::class, 'show']);
        Route::resource('students', StudentController::class)->only(['update', 'destroy']);
        Route::post('import-student/{slug}', [StudentController::class, 'import']);

        // student classroom
        Route::get('student-classrooms/{classroom}', [StudentClassroomController::class, 'byClassroom']);

        // teacher
        Route::get('teachers/{slug}', [TeacherController::class, 'index']);
        Route::post('teachers/{school}', [TeacherController::class, 'store']);
        Route::get('teacher-detail/{teacher}', [TeacherController::class, 'show']);
        Route::resource('teachers', TeacherController::class)->only(['update', 'destroy']);
    });
});
