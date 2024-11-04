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
    estQuestionController,
    SubmissionTaskController,
    UserCourseController,
    UserCourseTestController,
    UserQuizController
};
use App\Http\Controllers\{
    BlogController,
    CertificateController,
    ContactController,
    DiscussionAnswerController,
    DiscussionController,
    DiscussionTagController,
    EventAttendanceController,
    EventController,
    FaqController,
    Payment\TransactionController,
    RewardController,
    TagController,
    UpdatePasswordController,
    CourseTestQuestionController,
    UserEventAttendanceController,
    UserEventController,
    UserRewardController
};
use App\Helpers\ResponseHelper;
use App\Models\EventAttendance;

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

Route::get('test-email', [TransactionController::class, 'testEmail']);
Route::get('submission-tasks/download/{submissionTask}', [SubmissionTaskController::class, 'download']);
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
    Route::get('blogs/{blog}', [BlogController::class, 'show']);
    Route::get('categories', [CategoryController::class, 'index']);



    /**
     * Publicly Accessible Routes
     */
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);


    Route::resource('events', EventController::class)->except('show');
    Route::get('events-user', [EventController::class, 'pageUser']);
    Route::get('events/{slug}', [EventController::class, 'show']);

    Route::resource('categories', CategoryController::class)->except('index');

    Route::resources([
        'modules' => ModuleController::class,
        'sub-categories' => SubCategoryController::class,
    ], [
        'only' => ['update', 'destroy'],
        'middlware' => ['is_admin'],
    ]);

    Route::get('sub-modules/{sub_module}/edit', [SubModuleController::class, 'edit']);
    Route::post('sub-modules-update/{sub_module}', [SubModuleController::class, 'update']);
    Route::delete('sub-modules/{sub_module}', [SubModuleController::class, 'destroy']);
    Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
    Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev']);
    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);
    Route::get('courses/{slug}/share', [CourseController::class, 'share']);

    Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
    Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
    Route::get('course-reviews-latest', [CourseReviewController::class, 'latest']);

    Route::get('quizzes-get', [QuizController::class, 'get']);

    Route::resources([
        'faqs' => FaqController::class,
        'tags' => TagController::class
    ], [
        'except' => ['edit', 'create']
    ]);

    Route::get('faq-user', [FaqController::class, 'indexUser']);
    Route::get('rewards', [RewardController::class, 'index']);
    Route::get('user-rewards', [UserRewardController::class, 'index']);
    Route::get('rewards/{slug}', [RewardController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        // user
        Route::get('user-course-activities', [UserController::class, 'courseActivity']);

        Route::post('rewards-claim/{reward}', [RewardController::class, 'claim']);
        Route::patch('rewards-change/{user_reward}', [RewardController::class, 'change']);
        Route::resource('rewards', RewardController::class)->only(['store', 'update', 'destroy']);
        Route::resource('discussions', DiscussionController::class)->except(['index', 'create', 'edit', 'store']);
        Route::get('discussions/course/{slug}', [DiscussionController::class, 'index']);
        Route::post('discussions/{slug}', [DiscussionController::class, 'store']);
        Route::get('discussion-answers/{discussion}', [DiscussionAnswerController::class, 'index']);
        Route::post('discussion-answers/{discussion}/{discussion_answer?}', [DiscussionAnswerController::class, 'store']);
        Route::resource('discussion-answers', DiscussionAnswerController::class)->only(['update', 'destroy']);


        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy']);
        Route::get('blog/{blog}', [BlogController::class, 'show']);

        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resources([
            'sub-categories' => SubCategoryController::class,
        ], [
            'only' => ['store', 'update', 'destroy', 'show'],
            'middlware' => ['is_admin'],
        ]);
        Route::post('sub-categories/{category}', [SubCategoryController::class, 'store']);

        Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);

        Route::patch('contact/{contact}', [ContactController::class, 'update']);

        Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
        Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);
        Route::put('course-vouchers/{code}', [CourseVoucherController::class, 'update']);
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);


        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);
        Route::delete('module-questions/{module_question}', [ModuleQuestionController::class, 'destroy']);


        Route::get('quizzes/{slug}', [QuizController::class, 'index']);
        Route::get('quizzes', [QuizController::class, 'get']);
        Route::get('quiz-start/{quiz}', [QuizController::class, 'show']);
        Route::post('quizzes/{module}', [QuizController::class, 'store']);
        Route::delete('quizzes/{quiz}', [QuizController::class, 'destroy']);

        Route::get('course-tests-get', [CourseTestController::class, 'get']);

        Route::get('course-pre-test/{course_test}', [CourseTestController::class, 'preTest']);
        Route::get('course-post-test/{course_test}', [CourseTestController::class, 'postTest']);
        Route::post('course-submit-test/{user_course_test}', [CourseTestController::class, 'submit']);
        Route::get('course-test-statistic/{user_course_test}', [CourseTestController::class, 'statistic']);

        Route::get('user-course-tests', [UserCourseTestController::class, 'index']);

        Route::get('course-test-questions/{course_test}', [CourseTestQuestionController::class, 'index']);
        Route::post('course-test-questions/{course_test}', [CourseTestQuestionController::class, 'stokwre']);
        Route::resource('course-test-questions', CourseTestQuestionController::class)->only(['show', 'update', 'destroy']);

        Route::get('course-tests/{course}', [CourseTestController::class, 'index']);
        Route::get('course-test-start/{course_test}', [CourseTestController::class, 'show']);
        Route::post('course-tests/{slug}', [CourseTestController::class, 'store']);
        Route::resource('course-tests', CourseTestController::class)->only(['update', 'destroy']);
        Route::get('blog-detail/{slug}', [BlogController::class, 'showLanding']);

        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);


        // Route::get('submission-tasks/{course_task}', [SubmissionTaskController::class, 'index']);

        Route::get('user-courses', [UserCourseController::class, 'index']);
        Route::put('user-courses/{slug}/{sub_module}', [UserCourseController::class, 'userLastStep']);
        Route::post('user-courses-check', [UserCourseController::class, 'checkPayment']);

        Route::get('transaction/statistic', [TransactionController::class, 'groupByMonth']);
        Route::get('transactions-user', [TransactionController::class, 'getByUser']);
    });

    /**
     * Sanctum Authenticated Routes
     */
    Route::middleware('auth:sanctum')->group(function () {

        // event attendance
        Route::get('event-attendance/{event_attendance}/{date}', [EventController::class, 'attendance'])->name('event-attendance.store');
        Route::get('user-event-attendances/{event}', [UserEventAttendanceController::class, 'index']);

        // certificate
        Route::resource('certificates', CertificateController::class)->only(['update']);
        Route::post('{type}/certificates/{slug}', [CertificateController::class, 'store']);
        Route::get('{type}/certificates/{slug}', [CertificateController::class, 'show']);
        // Route::get('{type}/certificate-download/{slug}/{user_id}', [CertificateController::class, 'download']);


        Route::get('sub-modules/detail/{slug}', [SubModuleController::class, 'show'])->middleware('check_last_step_user');
        Route::get('sub-modules/detail/admin/{slug}', [SubModuleController::class, 'showAdmin']);

        Route::get('list-course', [CourseController::class, 'listCourse']);
        Route::get('list-module/{slug}', [ModuleController::class, 'listModuleWithSubModul']);
        Route::get('list-module/detail/{slug}', [ModuleController::class, 'listModule']);

        /**
         * User and Profile Management
         */
        Route::get('user-detail', [UserController::class, 'getByAuth']);
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
        Route::patch('courses-ready/{course}', [CourseController::class, 'readyToUse']);
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);
        Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store']);
        Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
        Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);
        Route::get('course-by-submodule/{subModule}', [CourseController::class, 'getBySubModule']);

        // count courses
        Route::get('courses/count', [CourseController::class, 'count']);

        /**
         * Blog Management
         */
        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy']);

        /**
         * Contact Management
         */
        Route::patch('contact', [ContactController::class, 'post']);

        /**
         * Module and Task Management
         */
        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);
        Route::post('modules/{slug}', [ModuleController::class, 'store']);
        Route::patch('modules-forward/{module}', [ModuleController::class, 'forward']);
        Route::patch('modules-backward/{module}', [ModuleController::class, 'backward']);
        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);

        /**
         * Submission Task Management
         */
        Route::post('submission-tasks/{moduleTask}', [SubmissionTaskController::class, 'store']);
        Route::get('submission-tasks/detail/{submissionTask}', [SubmissionTaskController::class, 'show']);
        // Route::get('submission-tasks/download/{submissionTask}', [SubmissionTaskController::class, 'download']);

        Route::get('check-finished-course/{userQuiz}', [CourseController::class, 'checkSubmit']);

        // Quiz Management
        Route::get('quizzes/working/{quiz}', [QuizController::class, 'show']);
        Route::get('quizzes-result/{user_quiz}', [QuizController::class, 'result']);
        Route::post('quizzes', [QuizController::class, 'store']);
        Route::post('quizzes-submit/{user_quiz}', [QuizController::class, 'submit']);

        Route::get('user-quizzes', [UserQuizController::class, 'getByUser']);

        // faq and discussion configuration
        Route::resources([
            'faqs' => FaqController::class,
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
    // Basic route definition
    Route::get('/event-attendances/{event}', [EventAttendanceController::class, 'index']);

    Route::resource('categories', CategoryController::class)->except('index');

    Route::resources([
        'modules' => ModuleController::class,
        'sub-modules' => SubModuleController::class,
        'sub-categories' => SubCategoryController::class,
    ], [
        'only' => ['update', 'destroy'],
        'middlware' => ['is_admin'],
    ]);

    Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);
    Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
    Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev']);
    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);
    Route::get('sub-categories', [SubCategoryController::class, 'index']);

    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);
    Route::get('courses/{slug}/share', [CourseController::class, 'share']);

    Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
    Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);

    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
    Route::get('course-reviews-latest', [CourseReviewController::class, 'latest']);

    Route::get('quizzes-get', [QuizController::class, 'get']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('module-questions/detail/admin/{module}', [ModuleQuestionController::class, 'showAdmin']);


        Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy']);
        Route::get('blog/{blog}', [BlogController::class, 'show']);

        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resources([
            'sub-categories' => SubCategoryController::class,
        ], [
            'only' => ['store', 'update', 'destroy', 'show'],
            'middlware' => ['is_admin'],
        ]);
        Route::post('sub-categories/{category}', [SubCategoryController::class, 'store']);

        Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);

        Route::patch('contact/{contact}', [ContactController::class, 'update']);

        Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
        Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);
        Route::put('course-vouchers/{code}', [CourseVoucherController::class, 'update']);
        Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
        Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);

        Route::get('module-tasks/{module}', [ModuleTaskController::class, 'index']);
        Route::post('module-tasks/{module}', [ModuleTaskController::class, 'store']);
        Route::get('module-tasks-detail/{module_task}', [ModuleTaskController::class, 'show']);
        Route::resource('module-tasks', moduletaskcontroller::class)->only(['update', 'destroy']);

        Route::get('module-questions/detail/{module}', [ModuleQuestionController::class, 'index']);
        Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);
        Route::delete('module-questions/{module_question}', [ModuleQuestionController::class, 'destroy']);


        // Route::get('quizzes/{slug}', [QuizController::class, 'index'])->middleware('check_access_quiz');
        Route::get('quizzes', [QuizController::class, 'get']);
        Route::get('quiz-start/{quiz}', [QuizController::class, 'show']);
        Route::post('quizzes/{module}', [QuizController::class, 'store']);

        Route::get('course-tests-get', [CourseTestController::class, 'get']);
        Route::get('course-tests/{slug}', [CourseTestController::class, 'index']);
        Route::get('course-test-start/{course_test}', [CourseTestController::class, 'show']);
        Route::post('course-tests/{course}', [CourseTestController::class, 'store']);

        Route::get('blog-detail/{slug}', [BlogController::class, 'showLanding']);

        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);


        Route::get('submission-tasks/{moduleTask}', [SubmissionTaskController::class, 'index']);

        // Route::get('user-courses/{course}', [UserCourseController::class, 'index']);
        Route::put('user-courses/{slug}/{sub_module}', [UserCourseController::class, 'userLastStep']);
        Route::post('user-courses-check', [UserCourseController::class, 'checkPayment']);
        Route::post('user-events-check', [UserEventController::class, 'checkPayment']);
        Route::get('user-events', [UserEventController::class, 'index']);
        Route::patch('user-events/{userEventId}', [UserEventController::class, 'setCertificate']);

        Route::get('transaction/statistic', [TransactionController::class, 'groupByMonth']);
    });
    /**
     * Password Reset
     */
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->middleware('guest')->name('password.email');
    Route::middleware('throttle:10,1')->prefix('password')->group(function () {
        Route::get('reset/{token}', [ResetPasswordController::class, 'resetToken'])->name('password.reset');
        Route::post('reset', [ResetPasswordController::class, 'reset']);
        Route::patch('update', [UpdatePasswordController::class, 'update'])->middleware('auth:sanctum');
    });

    /**
     * Unauthenticated Error
     */
    Route::get('login', function () {
        return ResponseHelper::error(null, 'Unauthenticated');
    })->name('login');

    Route::get('module-tasks/course/{courseSlug}', [ModuleTaskController::class, 'getByCourse']);
});

require_once('api/tripay.php');
