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
    SubmissionTaskController,
    UserCourseController
};
use App\Http\Controllers\{
    BlogController,
    ContactController,
    DiscussionAnswerController,
    DiscussionController,
    DiscussionTagController,
    EventController,
    FaqController,
    Payment\TransactionController,
    TagController
};
use App\Helpers\ResponseHelper;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
*/

Route::get('submission-tasks/download/{submissionTask}', [SubmissionTaskController::class, 'download'])->middleware('auth:sanctum');
Route::middleware('enable.cors')->group(function () {

    // Socialite Authentication
    Route::middleware(['web'])->group(function () {
        Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
        Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
    });

    // Publicly Accessible Routes
    Route::get('contact', [ContactController::class, 'index']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::resource('events', EventController::class)->except('show');
    Route::get('events/{slug}', [EventController::class, 'show']);
    Route::resource('categories', CategoryController::class)->except('index');
    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('quizzes-get', [QuizController::class, 'get']);

    // Upload Image
    Route::post('upload-image', [SubModuleController::class, 'uploadImage']);

    // Authentication
    Route::post('login', [LoginController::class, 'showLoginForm']);
    Route::post('register', [RegisterController::class, 'register']);

    // Authenticated Routes
    Route::middleware('auth:sanctum')->group(function () {

        // User and Profile Management
        Route::patch('profile-update', [ProfileController::class, 'update']);
        Route::get('/user', function (Request $request) {
            return \App\Models\User::with('roles')->find($request->user()->id);
        });

        // Email Verification
        Route::post('/email/resend', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification link sent']);
        });
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return response()->json(['message' => 'Email verified successfully']);
        })->middleware('signed')->name('verification.verify');

        // Course Management
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::get('courses/count', [CourseController::class, 'count']);
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);
        Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
        Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
        Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
        Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);

        // Blog Management
        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy', 'show']);

        // Module and SubModule Management
        Route::resources([
            'modules' => ModuleController::class,
            'sub-modules' => SubModuleController::class,
            'sub-categories' => SubCategoryController::class,
        ], [
            'only' => ['store', 'update', 'destroy'],
            'middleware' => ['is_admin'],
        ]);

        Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);
        Route::get('sub-modules/{subModule}/edit', [SubModuleController::class, 'edit']);
        Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
        Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev']);

        // Quiz Management
        Route::get('quizzes', [QuizController::class, 'get']);
        Route::post('quizzes', [QuizController::class, 'store']);

        // Transaction Management
        Route::get('transaction/statistic', [TransactionController::class, 'groupByMonth']);

        // Submission Task Management
        Route::post('submission-tasks/{moduleTask}', [SubmissionTaskController::class, 'store']);
        // Route::get('submission-tasks/download/{submissionTask}', [SubmissionTaskController::class, 'download']);

        // Other Routes
        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);

        // Reset Password
        Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->middleware('guest')->name('password.email');
        Route::middleware('throttle:10,1')->prefix('password')->group(function () {
            Route::get('reset/{token}', [ResetPasswordController::class, 'resetToken'])->name('password.reset');
            Route::post('reset', [ResetPasswordController::class, 'reset']);
        });
    });

    // Unauthenticated Error
    Route::get('login', function () {
        return ResponseHelper::error(null, 'Unauthenticated');
    })->name('login');
});

require_once('api/tripay.php');
