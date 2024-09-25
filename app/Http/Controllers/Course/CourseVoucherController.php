<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\CourseVoucherInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseVoucherRequest;
use App\Http\Resources\CourseVoucherResource;
use App\Models\Course;
use App\Models\CourseVoucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseVoucherController extends Controller
{
    private CourseVoucherInterface $courseVoucher;
    /**
     * Method __construct
     *
     * @param CourseVoucherInterface $courseVoucher [explicite description]
     *
     * @return void
     */
    public function __construct(CourseVoucherInterface $courseVoucher)
    {
        $this->courseVoucher = $courseVoucher;
    }
    /**
     * Method index
     *
     * @param Course $course [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Course $course): JsonResponse
    {
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
    public function store(CourseVoucherRequest $request, Course $course): JsonResponse
    {
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

    public function checkCode(Request $request) : JsonResponse {
        $voucher = $this->courseVoucher->getWhere(['code', $request->voucher_code]);
        if($voucher) return ResponseHelper::success($voucher, 'Berhasil menggunakan voucher');
        return ResponseHelper::error(null, "Voucher tidak valid");
    }
}
