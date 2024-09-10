<?php

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
use App\Http\Controllers\Course\SubCategoryController;
use App\Http\Controllers\Course\CourseReviewController;
use App\Http\Controllers\Course\CourseVoucherController;
use App\Http\Controllers\Course\ModuleQuestionController;
use App\Http\Controllers\Course\SubmissionTaskController;
use App\Http\Controllers\Course\CourseVoucherUserController;

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

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
    Route::get('course-reviews/course_review', [CourseReviewController::class, 'show']);
    Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);

    Route::get('course-vouchers/{course}', [CourseVoucherController::class, 'index']);
    Route::post('course-vouchers/{course}', [CourseVoucherController::class, 'store']);
    Route::patch('course-vouchers/{course_voucher}', [CourseVoucherController::class, 'update']);
    Route::delete('course-vouchers/{course_voucher}', [CourseVoucherController::class, 'destroy']);

    Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store']);

    Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);
    Route::post('quizzes/{module}', [QuizController::class, 'store']);

    Route::get('course-tasks/{course}', [CourseTaskController::class, 'index']);
    Route::post('course-tasks/{course}', [CourseTaskController::class, 'store']);

    Route::get('submission-tasks/{course_task}', [SubmissionTask::class, 'index']);
    Route::post('submission-tasks/{course_task}', [SubmissionTask::class, 'store']);

    Route::resources([
        'course-tasks' => CourseTaskController::class,
        'submission-tasks' => SubmissionTaskController::class,
    ], [
        'only' => ['update', 'destroy']
    ]);

    Route::resources([
        'quizzes' => QuizController::class,
        'module-questions' => ModuleQuestionController::class,
    ], [
        'except' => ['create', 'edit', 'store']
    ]);



    Route::resources([
        'categories' => CategoryController::class,
        'sub-categories' => SubCategoryController::class,
        'courses' => CourseController::class,
        'sub-modules' => SubModuleController::class,
    ], [
        'except' => ['create', 'edit']
    ]);

    Route::get('modules/{course}', [ModuleController::class, 'index']);
    Route::post('modules/{course}', [ModuleController::class, 'store']);
    Route::put('modules/{module}', [ModuleController::class, 'update']);
    Route::delete('modules/{module}', [ModuleController::class, 'destroy']);

    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);

    Route::get('payment-channels', [TripayController::class, 'getPaymentChannels']);
    Route::get('payment-instructions', [TripayController::class, 'getPaymentInstructions']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->middleware('guest')->name('password.email');

    Route::middleware('throttle:10,1')->prefix('password')->group(function () {
        Route::get('reset/{token}', [ResetPasswordController::class, 'resetToken'])->name('password.reset');
        Route::post('reset', [ResetPasswordController::class, 'reset']);
    });
});
