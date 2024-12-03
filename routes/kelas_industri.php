<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeSubmitController;
use App\Http\Controllers\DivisionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryClass\SchoolController;
use App\Http\Controllers\IndustryClass\StudentController;
use App\Http\Controllers\IndustryClass\ClassroomController;
use App\Http\Controllers\IndustryClass\SchoolYearController;
use App\Http\Controllers\IndustryClass\StudentClassroomController;
use App\Http\Controllers\IndustryClass\TeacherController;
use App\Http\Requests\IndustryClass\TeacherClassroomRequest;

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['is_admin'])->group(function () {

        // school
        Route::resource('schools', SchoolController::class)->only(['index', 'store', 'update', 'delete']);
        Route::get('schools/{slug}', [SchoolController::class, 'show']);

        // division
        Route::resource('divisions', DivisionController::class);

        // classroom
        Route::get('classrooms/{slug}', [ClassroomController::class, 'index']);
        Route::post('classrooms/{slug}', [ClassroomController::class, 'store']);
        Route::get('classroom-detail/{classroom}', [ClassroomController::class, 'show']);
        Route::patch('teacher-classrooms/{classroom}', [ClassroomController::class, 'teacherClassroom']);
        Route::patch('mentor-classrooms/{classroom}', [ClassroomController::class, 'mentorClassroom']);
        Route::resource('classrooms', ClassroomController::class)->only(['update', 'destroy']);

        //Mentor
        Route::get('get-mentors', [UserController::class, 'getMentor']);
        Route::get('mentors', [UserController::class, 'getMentorAdmin']);

        //Teacher
        Route::get('get-teachers/{slug}', [UserController::class, 'getTeacher']);

        //school year
        Route::resource('school-years', SchoolYearController::class)->except('destroy');
        Route::delete('school-years', [SchoolYearController::class, 'destroy']);

        // student
        Route::get('students/{slug}', [StudentController::class, 'index']);
        Route::post('students/{slug}', [StudentController::class, 'store']);
        Route::get('student-detail/{student}', [StudentController::class, 'show']);
        Route::resource('students', StudentController::class)->only(['update', 'destroy']);
        Route::post('import-student/{slug}', [StudentController::class, 'import']);

        // student classroom
        Route::get('student-classrooms/{classroom}', [StudentClassroomController::class, 'byClassroom']);
        Route::post('student-classrooms/{classroom}', [StudentClassroomController::class, 'store']);

        // teacher
        Route::get('teachers/{slug}', [TeacherController::class, 'index']);
        Route::post('teachers/{slug}', [TeacherController::class, 'store']);
        Route::get('teacher-detail/{teacher}', [TeacherController::class, 'show']);
        Route::resource('teachers', TeacherController::class)->only(['update', 'destroy']);
    });

    Route::resource('challenges', ChallengeController::class);
    Route::get('student/challenges/{classroomSlug}', [Challenge::class, 'getByClassroom']);

    Route::resource('challenge-submits', ChallengeSubmitController::class)->only(['update', 'destroy']);
    Route::post('challenge-submits/{challenge}', [ChallengeSubmitController::class, 'store']);

    Route::get('student/challenge-submits/{challenge}', [ChallengeSubmitController::class, 'index']);
    Route::get('mentor/challenge-submits/{challenge}', [ChallengeSubmitController::class, 'get_by_mentor']);
    Route::put('mentor/challenge-add-point/{challengeSubmit}', [ChallengeSubmitController::class, 'add_point']);
});

