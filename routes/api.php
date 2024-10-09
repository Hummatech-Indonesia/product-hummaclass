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
    DiscussionController,
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

    Route::post('upload-image', [SubModuleController::class, 'uploadImage']);

    /**
     * Authentication
     */
    Route::post('login', [LoginController::class, 'showLoginForm']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('contact', [ContactController::class, 'index']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);

    /**
     * Sanctum Authenticated Routes
     */
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('list-course', [CourseController::class, 'listCourse']);
        Route::get('list-module/{slug}', [ModuleController::class, 'listModuleWithSubModul']);
        Route::get('list-module/detail/{slug}', [ModuleController::class, 'listModule']);

        /**
         * User and Profile Management
         */
        Route::patch('profile-update', [ProfileController::class, 'update']);
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
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store'])->middleware('is_admin');
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy'])->middleware('is_admin');
        Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store'])->middleware('is_guest');
        Route::post('course-reviews/{course}', [CourseReviewController::class, 'store'])->middleware('is_guest');
        Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update'])->middleware('is_guest');
        Route::get('course-by-submodule/{subModule}', [CourseController::class, 'getBySubModule']);

        // count courses
        Route::get('courses/count', [CourseController::class, 'count'])->middleware('is_admin');

        /**
         * Blog Management
         */
        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy', 'show'])->middleware('is_admin');

        /**
         * Contact Management
         */
        Route::patch('contact/{contact}', [ContactController::class, 'update'])->middleware('is_admin');

        /**
         * Module and Task Management
         */
        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);
        Route::post('modules/{slug}', [ModuleController::class, 'store'])->middleware('is_admin');
        Route::patch('modules-forward/{module}', [ModuleController::class, 'forward'])->middleware('is_admin');
        Route::patch('modules-backward/{module}', [ModuleController::class, 'backward'])->middleware('is_admin');
        Route::post('module-tasks/{module}', [ModuleTaskController::class, 'store'])->middleware('is_admin');
        Route::get('module-questions/detail/{module}', [ModuleQuestionController::class, 'index']);
        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store'])->middleware('is_admin');

        /**
         * Submission Task Management
         */
        Route::post('submission-tasks/{course_task}', [SubmissionTask::class, 'store'])->middleware('is_admin');

        // Quiz Management
        Route::get('quizzes/working/{quiz}', [QuizController::class, 'show']);
        Route::get('quizzes-result/{userQuiz}', [QuizController::class, 'result']);
        Route::post('quizzes', [QuizController::class, 'store'])->middleware('is_admin');
        Route::post('quizzes-submit/{user_quiz}', [QuizController::class, 'submit'])->middleware('is_guest');

        // faq and discussion configuration
        Route::resources([
            'faqs' => FaqController::class,
            'discussions' => DiscussionController::class
        ], ['only', ['store', 'update', 'destroy']]);
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

    Route::resource('categories', CategoryController::class)->except('index');

    Route::resources([
        'modules' => ModuleController::class,
        'sub-modules' => SubModuleController::class,
        'sub-categories' => SubCategoryController::class,
    ], [
        'only' => ['update', 'destroy'],
        'middlware' => ['is_admin'],
    ]);

    Route::post('sub-modules/{module}', [SubModuleController::class, 'store'])->middleware('is_admin');
    Route::get('sub-modules/detail/{slug}', [SubModuleController::class, 'show']);
    Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
    Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev'])->middleware(['is_guest', 'is_admin']);
    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory'])->middleware('is_admin');

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);
    Route::get('courses/{slug}/share', [CourseController::class, 'share']);

    Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
    Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode'])->middleware('is_guest');

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
    Route::get('course-reviews-latest', [CourseReviewController::class, 'latest'])->middleware('is_admin');

    Route::get('quizzes-get', [QuizController::class, 'get']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy'])->middleware('is_admin');
        Route::get('blog/{blog}', [BlogController::class, 'show']);

        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resources([
            'sub-categories' => SubCategoryController::class,
        ], [
            'only' => ['store', 'update', 'destroy', 'show'],
            'middlware' => ['is_admin'],
        ]);
        Route::post('sub-categories/{category}', [SubCategoryController::class, 'store'])->middleware('is_admin');

        Route::get('sub-modules/detail/{slug}', [SubModuleController::class, 'show']);
        Route::post('sub-modules/{module}', [SubModuleController::class, 'store'])->middleware('is_admin');

        Route::patch('contact/{contact}', [ContactController::class, 'update'])->middleware('is_admin');

        Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index'])->middleware('is_admin');
        Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode'])->middleware('is_guest');
        Route::put('course-vouchers/{code}', [CourseVoucherController::class, 'update'])->middleware('is_admin');
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store'])->middleware('is_admin');
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy'])->middleware('is_admin');

        Route::post('module-tasks/{module}', [ModuleTaskController::class, 'store'])->middleware('is_admin');

        Route::get('module-questions/detail/{module}', [ModuleQuestionController::class, 'index'])->middleware('is_admin');
        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store'])->middleware('is_admin');
        Route::delete('module-questions/{module_question}', [ModuleQuestionController::class, 'destroy'])->middleware('is_admin');


        Route::get('quizzes/{slug}', [QuizController::class, 'index']);
        Route::get('quizzes', [QuizController::class, 'get']);
        Route::get('quiz-start/{quiz}', [QuizController::class, 'show']);
        Route::post('quizzes/{module}', [QuizController::class, 'store'])->middleware('is_admin');

        Route::get('course-tests-get', [CourseTestController::class, 'get']);
        Route::get('course-tests/{course}', [CourseTestController::class, 'index']);
        Route::get('course-test-start/{course_test}', [CourseTestController::class, 'show']);
        Route::post('course-tests/{course}', [CourseTestController::class, 'store'])->middleware('is_admin');

        Route::get('blog-detail/{slug}', [BlogController::class, 'showLanding']);

        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show'])->middleware('is_admin');

        Route::get('module-tasks/{module}', [ModuleTaskController::class, 'index']);
        Route::get('module-questions/detail/{module}', [ModuleQuestionController::class, 'index']);

        Route::get('submission-tasks/{course_task}', [SubmissionTask::class, 'index']);

        Route::get('user-courses/{course}', [UserCourseController::class, 'index']);
        Route::put('user-courses/{slug}/{sub_module}', [UserCourseController::class, 'userLastStep']);
        Route::post('user-courses-check', [UserCourseController::class, 'checkPayment']);

        Route::get('transaction/statistic', [TransactionController::class, 'groupByMonth'])->middleware('is_admin');
    });
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
