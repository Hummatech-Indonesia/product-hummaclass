<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseVoucher;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseVoucherRequest;
use App\Http\Resources\CourseVoucherResource;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CourseVoucherInterface;

class CourseVoucherController extends Controller
{
    private CourseVoucherInterface $courseVoucher;
    private CourseInterface $course;
    /**
     * Method __construct
     *
     * @param CourseVoucherInterface $courseVoucher [explicite description]
     *
     * @return void
     */
    public function __construct(CourseVoucherInterface $courseVoucher, CourseInterface $course)
    {
        $this->courseVoucher = $courseVoucher;
        $this->course = $course;
    }
    /**
     * Method index
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function index(string $courseSlug, Request $request)
    {
        $course = $this->course->showWithSlug($request, $courseSlug);
        $courseVouchers = $this->courseVoucher->getWhere(['course_id' => $course->id]);
        return ResponseHelper::success(CourseVoucherResource::collection($courseVouchers), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param CourseVoucherRequest $request [explicite description]
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CourseVoucherRequest $request, string $courseSlug): JsonResponse
    {
        $course = $this->course->showWithSlugWithoutRequest($courseSlug);
        $data = $request->validated();
        $data['course_id'] = $course->id;
        $this->courseVoucher->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param CourseVoucherRequest $request [explicite description]
     * @param CourseVoucher $courseVoucher [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CourseVoucherRequest $request, CourseVoucher $courseVoucher): JsonResponse
    {
        $this->courseVoucher->update($courseVoucher->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param CourseVoucher $courseVoucher [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(CourseVoucher $courseVoucher): JsonResponse
    {
        $this->courseVoucher->delete($courseVoucher->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }

    public function checkCode(Request $request)
    {
        $voucher = $this->courseVoucher->getByCode($request->voucher_code);
        if (!is_null($voucher)) {
            if ($voucher->transactions_count >= $voucher->usage_limit) {
                return ResponseHelper::error($voucher, trans('alert.voucher_limit'));
            }
            return ResponseHelper::success($voucher, trans('alert.voucher_valid'));
        } else {
            return ResponseHelper::error(null, trans('alert.voucher_invalid'), 404);
        }
    }
}
