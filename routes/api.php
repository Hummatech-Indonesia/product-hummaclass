<?php

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\SubmissionTask;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Course\QuizController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Course\ModulController;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\ModuleController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\Course\SubModuleController;
use App\Http\Controllers\Payment\TripayController;
use App\Services\TripayService;
use App\Http\Controllers\Course\CourseTaskController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Course\SubCategoryController;
use App\Http\Controllers\Course\CourseReviewController;
use App\Http\Controllers\Course\CourseVoucherController;
use App\Http\Controllers\Course\ModuleQuestionController;
use App\Http\Controllers\Course\SubmissionTaskController;
use App\Http\Controllers\Course\CourseVoucherUserController;
use App\Http\Controllers\Course\ModuleTaskController;
use App\Http\Controllers\Course\UserCourseController;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('enable.cors')->group(function () {

    /**
     * socialite auth
     */
    Route::middleware(['web'])->group(function () {
        Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
        Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
    });

    Route::post('login', [LoginController::class, 'showLoginForm']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('profile-update', [ProfileController::class, 'update']);
    });


    // Mengirim ulang email verifikasi
    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent']);
    })->middleware('auth:sanctum');

    // Verifikasi email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return response()->json(['message' => 'Email verified successfully']);
    })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('event', EventController::class);
        // Route::middleware('role:admin')->group(function () {

        Route::resources([
            'sub-modules' => SubModuleController::class,
            'sub-categories' => SubCategoryController::class,
        ], [
            'only' => ['update', 'destroy']
        ]);

            Route::resources([
                'courses' => CourseController::class,
                'sub-modules' => SubModuleController::class,
                'sub-categories' => SubCategoryController::class,
            ], [
                'only' => ['store', 'update', 'destroy', 'show']
            ]);
            Route::post('sub-categories/{category}', [SubCategoryController::class, 'store']);

        Route::post('sub-categories/{category}', [SubCategoryController::class, 'store']);

        Route::get('sub-modules/detail/{subModule}', [SubModuleController::class, 'show']);
        Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);

        Route::patch('contact/{contact}', [ContactController::class, 'update']);

        Route::get('course-vouchers/{course}', [CourseVoucherController::class, 'index']);
        Route::post('course-vouchers/{course}', [CourseVoucherController::class, 'store']);

        Route::post('module-tasks/{module}', [ModuleTaskController::class, 'store']);

        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);

        Route::post('quizzes/{module}', [QuizController::class, 'store']);

        Route::post('submission-tasks/{course_task}', [SubmissionTask::class, 'store']);

        Route::patch('modules-forward/{module}', [ModuleController::class, 'forward']);
        Route::patch('modules-backward/{module}', [ModuleController::class, 'backward']);
        // });
    });

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
    Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);


    Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store']);


    Route::get('module-tasks/{module}', [ModuleTaskController::class, 'index']);

    Route::get('submission-tasks/{course_task}', [SubmissionTask::class, 'index']);

    Route::resources([
        'categories' => CategoryController::class,
    ], [
        'except' => ['create', 'edit']
    ]);

    Route::get('user-courses/{course}', [UserCourseController::class, 'index']);

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);

    Route::get('modules/{slug}', [ModuleController::class, 'index']);
    Route::get('list-module/{slug}', [ModuleController::class, 'listModule']);

    Route::post('modules/{slug}', [ModuleController::class, 'store']);
    Route::get('modules/detail/{module}', [ModuleController::class, 'show']);


    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);


    Route::get('contact', [ContactController::class, 'index']);


    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->middleware('guest')->name('password.email');


    Route::middleware('throttle:10,1')->prefix('password')->group(function () {
        Route::get('reset/{token}', [ResetPasswordController::class, 'resetToken'])->name('password.reset');
        Route::post('reset', [ResetPasswordController::class, 'reset']);
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return \App\Models\User::with('roles')->find($request->user()->id);
    });

    Route::get('login', function () {
        return ResponseHelper::error(null, 'Unauthenticated');
    })->name('login');
});

require_once('api/tripay.php');
