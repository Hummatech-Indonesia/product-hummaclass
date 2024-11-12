<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseReviewController;
use App\Http\Controllers\Course\CourseTestController;
use App\Http\Controllers\Course\CourseVoucherController;
use App\Http\Controllers\Course\CourseVoucherUserController;
use App\Http\Controllers\Course\ModuleController;
use App\Http\Controllers\Course\ModuleQuestionController;
use App\Http\Controllers\Course\QuizController;
use App\Http\Controllers\Course\SubCategoryController;
use App\Http\Controllers\Course\SubmissionTaskController;
use App\Http\Controllers\Course\SubModuleController;
use App\Http\Controllers\Course\UserCourseController;
use App\Http\Controllers\Course\UserCourseTestController;
use App\Http\Controllers\Course\UserQuizController;
use App\Http\Controllers\CourseTestQuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscussionAnswerController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Payment\TransactionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserEventAttendanceController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\UserRewardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test-email', [TransactionController::class, 'testEmail']);
Route::get('submission-tasks/download/{submissionTask}', [SubmissionTaskController::class, 'download']);
Route::middleware('enable.cors')->group(function () {

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
     * Authentication
     */
    Route::post('login', [LoginController::class, 'showLoginForm']);
    Route::post('register', [RegisterController::class, 'register']);

    //contact
    Route::get('contact', [ContactController::class, 'index']);

    //Blog
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blog-detail/{slug}', [BlogController::class, 'showLanding']);

    //Category
    Route::get('categories', [CategoryController::class, 'index']);

    //Event
    Route::get('events-user', [EventController::class, 'pageUser']);
    Route::get('events/{slug}', [EventController::class, 'show']);

    Route::get('sub-categories/category/{category}', [SubCategoryController::class, 'getByCategory']);
    Route::get('sub-categories', [SubCategoryController::class, 'index']);

    //Courses
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('top-courses', [CourseController::class, 'topCourses']);
    Route::get('courses/{slug}', [CourseController::class, 'show']);
    Route::get('courses/{slug}/share', [CourseController::class, 'share']);

    //Course Review
    Route::get('course-reviews', [CourseReviewController::class, 'index']);
    Route::get('course-reviews/{course_review}', [CourseReviewController::class, 'show']);
    Route::get('course-reviews-latest', [CourseReviewController::class, 'latest']);

    //Quiz
    Route::get('quizzes-get', [QuizController::class, 'get']);

    //FAQ
    Route::get('faqs/{faq}', [FaqController::class, 'show']);
    Route::get('faqs', [FaqController::class, 'index']);

    //Reward
    Route::get('rewards', [RewardController::class, 'index']);
    Route::get('rewards/{slug}', [RewardController::class, 'show']);


    /**
     * Socialite Authentication
     */
    Route::middleware(['web'])->group(function () {
        Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
        Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
    });


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('module-questions/detail/{module}', [ModuleQuestionController::class, 'index']);

        Route::get('course-test-questions/{course_test}', [CourseTestQuestionController::class, 'index']);
        Route::post('course-test-questions/{course_test}', [CourseTestQuestionController::class, 'store']);
        Route::resource('course-test-questions', CourseTestQuestionController::class)->only(['show', 'update', 'destroy']);

        Route::get('user-quizzes', [UserQuizController::class, 'getByUser']);


        Route::get('course-tests-get', [CourseTestController::class, 'get']);
        Route::get('course-pre-test/{course_test}', [CourseTestController::class, 'preTest']);
        Route::get('course-post-test/{course_test}', [CourseTestController::class, 'postTest']);
        Route::post('course-submit-test/{user_course_test}', [CourseTestController::class, 'submit']);
        Route::get('course-test-statistic/{user_course_test}', [CourseTestController::class, 'statistic']);

        Route::get('course-tests/{slug}', [CourseTestController::class, 'index']);
        Route::get('course-test-start/{course_test}', [CourseTestController::class, 'show']);
        Route::post('course-tests/{slug}', [CourseTestController::class, 'store']);
        Route::resource('course-tests', CourseTestController::class)->only(['update', 'destroy']);

        //Discussion Answer
        Route::get('discussion-answers/{discussion}', [DiscussionAnswerController::class, 'index']);
        Route::post('discussion-answers/{discussion}/{discussion_answer?}', [DiscussionAnswerController::class, 'store']);
        Route::resource('discussion-answers', DiscussionAnswerController::class)->only(['update', 'destroy']);

        //Quiz
        Route::get('quizzes/{slug}', [QuizController::class, 'index']);
        Route::get('quizzes', [QuizController::class, 'get']);
        Route::get('quiz-start/{quiz}', [QuizController::class, 'show']);
        Route::post('quizzes/{module}', [QuizController::class, 'store']);
        Route::delete('quizzes/{quiz}', [QuizController::class, 'destroy']);

        //User
        Route::get('user-detail', [UserController::class, 'getByAuth']);
        Route::get('user-added', [UserController::class, 'newestCount']);
        Route::get('users', [UserController::class, 'index']);
        Route::patch('user-update', [UserController::class, 'customUpdate']);
        Route::get('users/{user}', [UserController::class, 'show']);

        //Course Voucher
        Route::get('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'index']);
        Route::get('course-vouchers/{courseSlug}/check', [CourseVoucherController::class, 'checkCode']);


        Route::patch('profile-update', [ProfileController::class, 'update']);

        //course
        Route::get('check-finished-course/{userQuiz}', [CourseController::class, 'checkSubmit']);
        Route::get('course-by-submodule/{subModule}', [CourseController::class, 'getBySubModule']);

        Route::get('list-course', [CourseController::class, 'listCourse']);

        Route::get('modules/{slug}', [ModuleController::class, 'index']);
        Route::get('modules/detail/{module}', [ModuleController::class, 'show']);

        Route::get('list-module/{slug}', [ModuleController::class, 'listModuleWithSubModul']);
        Route::get('list-module/detail/{slug}', [ModuleController::class, 'listModule']);

        Route::get('submission-tasks/detail/{submissionTask}', [SubmissionTaskController::class, 'show']);

        Route::middleware(['is_admin'])->group(function () {

            //Module Question
            Route::post('module-questions/{module}', [ModuleQuestionController::class, 'store']);
            Route::delete('module-questions/{module_question}', [ModuleQuestionController::class, 'destroy']);
            Route::get('module-questions/detail/admin/{module}', [ModuleQuestionController::class, 'showAdmin']);

            Route::post('course-voucher-users', [CourseVoucherUserController::class, 'store']);

            //User Course Test
            Route::get('user-course-tests', [UserCourseTestController::class, 'index']);

            //Reward
            Route::resource('rewards', RewardController::class)->only(['store', 'update', 'destroy']);
            Route::get('user-rewards', [UserRewardController::class, 'index']);

            //Discussion
            Route::resource('discussions', DiscussionController::class)->except(['index', 'create', 'edit', 'store']);

            Route::get('dashboard-api', [DashboardController::class, 'index']);

            //User
            Route::get('users', [UserController::class, 'index']);
            Route::get('users/{user}', [UserController::class, 'show']);

            //Transaction
            Route::get('latest-transactions', [TransactionController::class, 'getLatest']);
            Route::get('transaction/statistic', [TransactionController::class, 'groupByMonth']);

            //Sub Module
            Route::post('upload-image', [SubModuleController::class, 'uploadImage']);

            Route::get('sub-modules/{sub_module}/edit', [SubModuleController::class, 'edit']);
            Route::post('sub-modules-update/{sub_module}', [SubModuleController::class, 'update']);
            Route::delete('sub-modules/{sub_module}', [SubModuleController::class, 'destroy']);
            Route::post('sub-modules/{module}', [SubModuleController::class, 'store']);
            Route::get('sub-modules/detail/admin/{slug}', [SubModuleController::class, 'showAdmin']);

            //Blog
            Route::resource('blogs', BlogController::class)->only(['store', 'update', 'destroy', 'show']);

            //Category
            Route::resource('categories', CategoryController::class)->except('index');

            //Event
            Route::resource('events', EventController::class)->except('show');

            //User Event
            Route::get('user-events', [UserEventController::class, 'index']);
            Route::get('user-events/{slug}', [UserEventController::class, 'show']);

            //Modules
            Route::resource('modules', ModuleController::class)->only(['update', 'destroy']);

            //Sub Category
            Route::resource('sub-categories', SubCategoryController::class)->only(['update', 'destroy']);
            Route::post('sub-categories/{category}', [SubCategoryController::class, 'store']);

            //Course
            Route::resource('courses', CourseController::class)->except(['index', 'show']);
            Route::get('course-statistic/{slug}', [CourseController::class, 'statistic']);
            Route::patch('courses-ready/{course}', [CourseController::class, 'readyToUse']);
            Route::get('courses/count', [CourseController::class, 'count']);

            //Course Voucher
            Route::post('course-vouchers/{courseSlug}', [CourseVoucherController::class, 'store']);
            Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);
            Route::put('course-vouchers/{code}', [CourseVoucherController::class, 'update']);
            Route::delete('course-vouchers/{courseVoucher}', [CourseVoucherController::class, 'destroy']);


            //UserCourse
            Route::get('user-courses', [UserCourseController::class, 'index']);

            //FAQ & Tag
            Route::resources([
                'faqs' => FaqController::class,
                'tags' => TagController::class
            ], [
                'except' => ['edit', 'create']
            ]);
        });

        Route::middleware(['guest'])->group(function () {

            Route::post('submission-tasks/{moduleTask}', [SubmissionTaskController::class, 'store']);

            //Discussion
            Route::get('discussions/course/{slug}', [DiscussionController::class, 'index']);
            Route::post('discussions/{slug}', [DiscussionController::class, 'store']);


            //Reward
            Route::post('rewards-claim/{reward}', [RewardController::class, 'claim']);
            Route::patch('rewards-change/{user_reward}', [RewardController::class, 'change']);

            //Quiz
            Route::get('quizzes/working/{quiz}', [QuizController::class, 'show']);
            Route::get('quizzes-result/{user_quiz}', [QuizController::class, 'result']);
            Route::post('quizzes', [QuizController::class, 'store']);
            Route::post('quizzes-submit/{user_quiz}', [QuizController::class, 'submit']);
            //User
            Route::get('user-course-activities', [UserController::class, 'courseActivity']);
            Route::get('user-event-activities', [UserController::class, 'eventActivity']);
            //Course Review
            Route::post('course-reviews/{course}', [CourseReviewController::class, 'store']);
            Route::patch('course-reviews/{course_review}', [CourseReviewController::class, 'update']);

            //Transaction    
            Route::get('transactions-user', [TransactionController::class, 'getByUser']);

            //Sub Module
            Route::get('sub-modules/detail/{slug}', [SubModuleController::class, 'show'])->middleware('check_last_step_user');
            Route::get('sub-modules/next/{slug}', [SubModuleController::class, 'next']);
            Route::get('sub-modules/prev/{slug}', [SubModuleController::class, 'prev']);

            //Event
            Route::get('event-attendance/{event_attendance}/{date}', [EventController::class, 'attendance'])->name('event-attendance.store');

            //User Event
            Route::post('user-events-check', [UserEventController::class, 'checkPayment']);
            Route::patch('user-events/{userEventId}', [UserEventController::class, 'setCertificate']);

            // UserCourse
            Route::put('user-courses/{slug}/{sub_module}', [UserCourseController::class, 'userLastStep']);
            Route::post('user-courses-check', [UserCourseController::class, 'checkPayment']);

            //User Event Attendance
            Route::get('user-event-attendances/{user_event}', [UserEventAttendanceController::class, 'index']);

            // certificate
            Route::resource('certificates', CertificateController::class)->only(['update']);
            Route::post('{type}/certificates/{slug}', [CertificateController::class, 'store']);
            Route::get('{type}/certificates/{slug}', [CertificateController::class, 'show']);
        });
    });
});
