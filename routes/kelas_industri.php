<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryClass\SchoolController;
use App\Http\Controllers\IndustryClass\StudentController;
use App\Http\Controllers\IndustryClass\ClassroomController;
use App\Http\Controllers\StudentClassroomController;

Route::resource('schools', SchoolController::class);
Route::post('import-student', [StudentController::class, 'import']);

Route::post('student-classrooms', [StudentClassroomController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('classrooms/{school}', [ClassroomController::class, 'store']);
    Route::resource('classrooms', ClassroomController::class)->only(['update', 'destroy']);
});
