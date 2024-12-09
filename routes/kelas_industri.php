<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceStudentController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeSubmitController;
use App\Http\Controllers\Course\CourseTestController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\IndustryClass\AssesmentFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryClass\SchoolController;
use App\Http\Controllers\IndustryClass\StudentController;
use App\Http\Controllers\IndustryClass\ClassroomController;
use App\Http\Controllers\IndustryClass\LearningPathController;
use App\Http\Controllers\IndustryClass\SchoolYearController;
use App\Http\Controllers\IndustryClass\StudentClassroomController;
use App\Http\Controllers\IndustryClass\TeacherController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\JournalPresenceController;
use App\Http\Controllers\ZoomController;
use App\Http\Requests\IndustryClass\TeacherClassroomRequest;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('get-classrooms', [ClassroomController::class, 'getAll']);
    Route::get('classrooms/{slug}', [ClassroomController::class, 'index']);

    Route::get('student-detail/{student}', [StudentController::class, 'show']);
    Route::get('student-auth', [StudentController::class, 'getByAuth']);

    Route::get('student-classrooms/{classroom}', [StudentClassroomController::class, 'byClassroom']);

    Route::get('show/classroom/{classroom}', [ClassroomController::class, 'show']);

    Route::middleware(['is_admin'])->group(function () {

        // school
        Route::resource('schools', SchoolController::class)->only(['index', 'store', 'update', 'delete']);
        Route::resource('learning-paths', LearningPathController::class);
        Route::get('schools/{slug}', [SchoolController::class, 'show']);

        // division
        Route::resource('divisions', DivisionController::class);

        // classroom
        Route::post('classrooms/{slug}', [ClassroomController::class, 'store']);
        Route::get('classroom-detail/{classroom}', [ClassroomController::class, 'show']);
        Route::patch('teacher-classrooms/{classroom}', [ClassroomController::class, 'teacherClassroom']);
        Route::patch('mentor-classrooms/{classroom}', [ClassroomController::class, 'mentorClassroom']);
        Route::resource('classrooms', ClassroomController::class)->only(['update', 'destroy']);

        //Mentor
        Route::get('get-mentors', [UserController::class, 'getMentor']);
        Route::get('mentors', [UserController::class, 'getMentorAdmin']);
        Route::post('mentors', [UserController::class, 'createMentor']);
        Route::get('mentors/{user}', [UserController::class, 'show']);
        Route::post('mentors-update/{mentor}', [UserController::class, 'updateMentor']);

        //Teacher
        Route::get('get-teachers/{slug}', [UserController::class, 'getTeacher']);

        //school year
        Route::resource('school-years', SchoolYearController::class)->except('destroy');
        Route::delete('school-years', [SchoolYearController::class, 'destroy']);

        // student
        Route::get('students/{slug}', [StudentController::class, 'index']);
        Route::post('students/{slug}', [StudentController::class, 'store']);
        Route::resource('students', StudentController::class)->only(['update', 'destroy']);
        Route::post('import-student/{slug}', [StudentController::class, 'import']);
        Route::get('student-without-classroom/{slugSchool}', [StudentController::class, 'withoutClassroom']);

        // Assesment Form
        Route::post('assesment-form/{division}/{classLevel}/{type}', [AssesmentFormController::class, 'store']);
        Route::get('assesment-form/{division}/{classLevel}', [AssesmentFormController::class, 'index']);

        // student classroom
        Route::post('student-classrooms/{classroom}', [StudentClassroomController::class, 'store']);

        // teacher
        Route::get('teachers/{slug}', [TeacherController::class, 'index']);
        Route::post('teachers/{slug}', [TeacherController::class, 'store']);
        Route::get('teacher-detail/{teacher}', [TeacherController::class, 'show']);
        Route::resource('teachers', TeacherController::class)->only(['update', 'destroy']);

        Route::resource('zooms', ZoomController::class);
    });

    Route::get('course-teacher', [CourseTestController::class, 'getByTeacher']);

    Route::get('schools-all', [SchoolController::class, 'getAll']);
    Route::get('detail/classroom/{slug}', [ClassroomController::class, 'showDetailClassroom']);

    //Teacher
    Route::get('class-teacher', [ClassroomController::class, 'listClassroomByTeacher']);
    Route::get('teacher/classrooms', [ClassroomController::class, 'showClassroomTeacher']);
    Route::resource('journal-presences', JournalPresenceController::class);

    //Mentor
    Route::get('student/challenge-submits/{challenge}', [ChallengeSubmitController::class, 'index']);
    Route::get('student/challenges/{classroomSlug}', [ChallengeController::class, 'getByClassroom']);

    Route::resource('challenges', ChallengeController::class);
    Route::resource('challenge-submits', ChallengeSubmitController::class)->only(['update', 'destroy']);
    Route::get('submit-challenge/{challenge}', [ChallengeController::class, 'showChallengeSubmit']);
    

    Route::resource('attendances', AttendanceController::class)->except(['edit']);

    Route::resource('attendances', AttendanceController::class)->except(['edit', 'show']);
    Route::get('attendances/{slug}', [AttendanceController::class, 'show']);
    Route::put('attendances-status/{attendance}', [AttendanceController::class, 'edit']);

    Route::get('attendance/student/{attendance}', [AttendanceStudentController::class, 'store']);

    Route::put('mentor/challenge-add-point/{challenge}', [ChallengeSubmitController::class, 'add_point']);
    Route::get('mentor/classrooms', [ClassroomController::class, 'listClassroom']);
    Route::get('mentor/dashboard/classrooms', [ClassroomController::class, 'listClassroomDashboard']);

    Route::get('mentor/detail-student/classroom', [ClassroomController::class, 'showDetailStudent']);

    Route::resource('journals', JournalController::class)->except(['update']);
    Route::post('journals/{journal}', [JournalController::class, 'update']);
    Route::get('mentor/student/list', [StudentController::class, 'listRangeStudent']);

    //Student
    Route::post('challenge-submits/{challenge}', [ChallengeSubmitController::class, 'store']);
    Route::get('student/dashboard', [StudentController::class, 'detailStudent']);
    Route::get('student/list-student', [StudentClassroomController::class, 'listStudent']);
    Route::get('student/list-range', [StudentController::class, 'listRangeStudent']);
    Route::get('student/challenge', [StudentController::class, 'showChallenge']);
});

Route::get('challenge/download-zip/{challenge}', [ChallengeController::class, 'download_zip']);
