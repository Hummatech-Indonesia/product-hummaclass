<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryClass\SchoolController;
use App\Http\Controllers\IndustryClass\StudentController;
use App\Http\Controllers\IndustryClass\ClassroomController;
use App\Http\Controllers\StudentClassroomController;
use App\Http\Controllers\IndustryClass\TeacherController;

Route::post('import-student', [StudentController::class, 'import']);

Route::post('student-classrooms', [StudentClassroomController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    // school
    Route::resource('schools', SchoolController::class)->only(['index', 'store', 'update', 'delete']);
    Route::get('school-detail/{slug}', [SchoolController::class, 'show']);

    // classroom
    Route::get('classrooms/{slug}', [ClassroomController::class, 'index']);
    Route::post('classrooms/{school}', [ClassroomController::class, 'store']);
    Route::get('classroom-detail', [ClassroomController::class, 'show']);
    Route::resource('classrooms', ClassroomController::class)->only(['update', 'destroy']);

    // student
    Route::get('students/{slug}', [StudentController::class, 'index']);
    Route::post('students/{school}', [StudentController::class, 'store']);
    Route::get('student-detail/{student}', [StudentController::class, 'show']);
    Route::resource('students', StudentController::class)->only(['update', 'destroy']);

    // teacher
    Route::get('teachers/{slug}', [TeacherController::class, 'index']);
    Route::post('teachers/{school}', [TeacherController::class, 'store']);
    Route::get('teacher-detail/{teacher}', [TeacherController::class, 'show']);
    Route::resource('teachers', TeacherController::class)->only(['update', 'destroy']);

});
