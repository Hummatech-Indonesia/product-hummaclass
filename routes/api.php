<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    UserController,
    ProfileController,
    SocialiteController,
    ResetPasswordController,
    VerificationController
};
use App\Http\Controllers\Course\{
    QuizController,
    ModuleController,
    CourseController,
    CategoryController,
    SubCategoryController,
    SubModuleController,
    CourseReviewController,
    CourseTestController,
    CourseVoucherController,
    CourseVoucherUserController,
    ModuleQuestionController,
    ModuleTaskController,
    CourseTaskController,
    UserCourseController
};
use App\Http\Controllers\{
    BlogController,
    ContactController,
    EventController,
    FaqController,
    Payment\TransactionController
};
use App\Models\SubmissionTask;
use App\Helpers\ResponseHelper;

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
     * Socialite Authentication
     */
    Route::middleware(['web'])->group(function () {
        Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
        Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
    });

    /**
     * Authentication
     */
    Route::post('login', [LoginController::class, 'showLoginForm']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('contact', [ContactController::class, 'index']);
    Route::get('blogs', [BlogController::class, 'index']);

    /**
     * Sanctum Authenticated Routes
     */
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('list-course', [CourseController::class, 'listCourse']);

        Route::get('list-module/{slug}', [ModuleController::class, 'listModule']);

        /**
         * User and Profile Management
         */
        Route::post('profile-update', [ProfileController::class, 'update']);
        Route::get('/user', function (Request $request) {
            return \App\Models\User::with('roles')->find($request->user()->id);
        });

        /**
         * Email Verification
         */
        Route::post('/email/resend', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification link sent']);
        });
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return response()->json(['message' => 'Email verified successfully']);
        })->middleware('signed')->name('verification.verify');

        /**
         * Course Management
         */
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);
        Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store']);
        Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
        Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);

        /**
         * Blog Management
         */
        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy', 'show']);

        /**
         * Contact Management
         */
        Route::patch('contact/{contact}', [ContactController::class, 'update']);

        /**
         * Module and Task Management
         */
        Route::post('modules/{slug}', [ModuleController::class, 'store']);
        Route::patch('modules-forward/{module}', [ModuleController::class, 'forward']);
        Route::patch('modules-backward/{module}', [ModuleController::class, 'backward']);
        Route::post('module-tasks/{module}', [ModuleTaskController::class, 'store']);
        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);

        /**
         * Submission Task Management
         */
        Route::post('submission-tasks/{course_task}', [SubmissionTask::class, 'store']);

        // Quiz Management
        Route::get('quizzes/{quiz}', [QuizController::class, 'show']);
        Route::post('quizzes', [QuizController::class, 'store']);
        Route::post('quizzes-submit/{user_quiz}', [QuizController::class, 'submit']);

        // faq configuration
        Route::resource('faqs', FaqController::class)->only(['store', 'update', 'destroy']);
    });

    /**
     * Publicly Accessible Routes
     */
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);

    Route::get('faqs', [FaqController::class, 'index']);
    Route::get('faqs/{faq}', [FaqController::class, 'show']);

    Route::resource('events', EventController::class)->except('show');
    Route::get('events/{slug}', [EventController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);

    Route::resources([
        'modules' => ModuleController::class,
        'sub-modules' => SubModuleController::class,
        'sub-categories' => SubCategoryController::class,
    ], [
        'only' => ['update', 'destroy']
    ]);

    Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);
    Route::get('sub-modules/detail/{slug}', [SubModuleController::class, 'show']);
    Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
    Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev']);
    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);

    Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
    Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);

    Route::get('quizzes-get', [QuizController::class, 'get']);

    /**
     * Password Reset
     */
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->middleware('guest')->name('password.email');
    Route::middleware('throttle:10,1')->prefix('password')->group(function () {
        Route::get('reset/{token}', [ResetPasswordController::class, 'resetToken'])->name('password.reset');
        Route::post('reset', [ResetPasswordController::class, 'reset']);
    });

    /**
     * Unauthenticated Error
     */
    Route::get('login', function () {
        return ResponseHelper::error(null, 'Unauthenticated');
    })->name('login');
});

require_once('api/tripay.php');
