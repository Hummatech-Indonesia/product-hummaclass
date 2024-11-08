<?php

namespace App\Http\Controllers\Payment;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\Course\UserEventInterface;
use App\Contracts\Interfaces\EventInterface;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PaymentChannelResource;
use App\Contracts\Interfaces\TransactionInterface;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use App\Models\UserEvent;
use App\Traits\PaginationTrait;

class TransactionController extends Controller
{
    use PaginationTrait;
    private TransactionInterface $transaction;
    private UserCourseInterface $userCourse;
    private UserEventInterface $userEvent;
    private CourseVoucherInterface $courseVoucher;
    private TripayService $service;
    private TransactionService $transactionService;
    private EventInterface $event;
    private CourseInterface $course;
    public function __construct(TransactionInterface $transaction, CourseVoucherInterface $courseVoucher, EventInterface $event, UserEventInterface $userEvent, CourseInterface $course, UserCourseInterface $userCourse, TransactionService $transactionService, TripayService $service)
    {
        $this->transaction = $transaction;
        $this->courseVoucher = $courseVoucher;
        $this->userEvent = $userEvent;
        $this->userCourse = $userCourse;
        $this->event = $event;
        $this->course = $course;
        $this->transactionService = $transactionService;
        $this->service = $service;
    }
    public function getPaymentChannels(): JsonResponse
    {
        $paymentChannels = $this->service->handlePaymentChannels();
        return ResponseHelper::success($paymentChannels, trans('alert.fetch_success'));
    }
    public function getPaymentInstructions(Request $request): JsonResponse
    {
        return response()->json($paymentInstructions = $this->service->handlePaymentInstructions($request->code));
        // return ResponseHelper::success($paymentInstructions, trans('alert.fetch_success'));
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('page')) {
            $categories = $this->transaction->customPaginate($request);
            $data['paginate'] = $this->customPaginate($categories->currentPage(), $categories->lastPage());
            $data['data'] = TransactionResource::collection($categories);
        } else {
            $categories = $this->transaction->search($request);
            $data['data'] = TransactionResource::collection($categories);
        }
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    public function getLatest(): JsonResponse
    {
        $transactions = $this->transaction->getLatest();
        return ResponseHelper::success(TransactionResource::collection($transactions), trans('alert.fetch_success'));
    }
    public function getByUser(): JsonResponse
    {
        $transactions = $this->transaction->getWhere(['user_id' => auth()->user()->id]);
        return ResponseHelper::success(TransactionResource::collection($transactions), trans('alert.fetch_success'));
    }

    public function show(mixed $id): mixed
    {
        $transaction = $this->transaction->show($id);
        return ResponseHelper::success(TransactionResource::make($transaction));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $course
     * @return mixed
     */
    public function store(Request $request, $productType, string $id): mixed
    {
        if ($course = $this->course->show($id)->currentUserCourse->user->id == auth()->user()->id) {
            return  ResponseHelper::error(null, "anda sudah membeli kursus ini");
        } else if ($course = $this->course->show($id)->currentUserCourse->user->id == auth()->user()->id) {
            return  ResponseHelper::error(null, "anda sudah bergabung event ini");
        }

        $voucher = $this->courseVoucher->getByCode($request->voucher_code);
        if ($productType == 'course') {
            $course = $this->course->show($id);
            if (!$course->is_premium) {
                $userCourse = $this->transactionService->handleCerateUserCourse($course, (object) ['user_id' => auth()->user()->id, 'course_id' => $course->id]);
                return ResponseHelper::success($userCourse, 'Berhasil');
            } else {
                $transaction = json_decode($this->service->handelCreateTransaction($request, $course, $voucher), 1);
            }
        } else if ($productType == 'event') {
            $event = $this->event->show($id);
            if (!$event->price > 0) {
                $userEvent = $this->transactionService->handleCerateUserCourse($event, (object) ['user_id' => auth()->user()->id, 'event_id' => $event->id]);
                return ResponseHelper::success($userEvent, 'Berhasil');
            } else {
                $transaction = json_decode($this->service->handelCreateTransaction($request, $event, $voucher), 1);
            }
        }

        if ($transaction['success']) {
            $data = [
                'id' => $transaction['data']['reference'],
                'user_id' => auth()->user()->id,
                'course_id' => $course->id ?? null,
                'event_id' => $event->id ?? null,
                'invoice_id' => $transaction['data']['merchant_ref'],
                'fee_amount' => $transaction['data']['fee_merchant'],
                'amount' => $course->price ?? $event->price,
                'invoice_url' => $transaction['data']['checkout_url'],
                'expiry_date' => Carbon::createFromTimestamp($transaction['data']['expired_time'])->toDateTimeString(),
                'paid_amount' => 0,
                'payment_channel' => $transaction['data']['payment_name'],
                'payment_method' => $transaction['data']['payment_method'],
                'course_voucher_id' => $voucher->id ?? null
            ];
            $transactionResult = $this->transaction->store($data);
            $transactionResult->reference = $transaction['data']['reference'];
            return ResponseHelper::success(['transaction' => $transactionResult, 'voucher' => $voucher], 'Transaksi berhasil');
        } else {
            return ResponseHelper::error($transaction);
        }
    }

    /**
     * callback
     *
     * @param  mixed $request
     * @return void
     */
    public function callback(Request $request)
    {
        return $this->transactionService->handlePaymentCallback($request);
    }

    /**
     * returnCallback
     *
     * @param  mixed $request
     * @return void
     */
    public function returnCallback(Request $request)
    {
        return 'return callback';
    }

    public function checkStatus(Request $request, $reference)
    {
        $response = Http::withToken(config('tripay.api_key'))->get(config('tripay.api_url') . 'transaction/detail?reference=' . $reference);

        // dd($response->getStatusCode());
        return $response;
    }

    public function delete(mixed $id): mixed
    {
        return $this->delete($id);
    }

    public function groupByMonth(): JsonResponse
    {
        $transactions = $this->transaction->countByMonth();
        return ResponseHelper::success([
            'transaction' => $transactions['data'],
            'months' => $transactions['months'],
            'thisMountIncome' => $transactions['thisMountIncome']
        ]);
    }

    // public function testEmail(): mixed {
    //     return $this->transactionService->sendEmailEvent($data);
    // }
}
