<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Blog;
use App\Models\Course;
use App\Models\CourseVoucher;
use App\Models\Event;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $data['course_count'] = Course::count();
        $data['event_count'] = Event::count();
        $data['sub_category_count'] = SubCategory::count();
        $data['course_voucher_count'] = CourseVoucher::count();
        $data['blog_count_count'] = Blog::count();
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
}
