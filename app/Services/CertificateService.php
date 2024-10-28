<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CertificateRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Models\UserCourse;
use App\Traits\UploadTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateService
{
    private CertificateInterface $certificate;
    private CourseInterface $course;
    public function __construct(CertificateInterface $certificate, CourseInterface $course)
    {
        $this->certificate = $certificate;
        $this->course = $course;
    }
    public function store(CertificateRequest $request, string $slug)
    {
        $data = $request->validated();

        $course = $this->course->showWithSlug($slug);

        $userCourse = UserCourse::where([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id
        ])->firstOrFail();

        $data['user_course_id'] = $userCourse->id;

        $certificates = Certificate::count();
        $data['code'] = '12' . date('Ymd') . str_pad($certificates + 1, 4, '0', STR_PAD_LEFT);

        $this->certificate->store($data);
        return true;
    }

    public function download(string $slug, string $user_id)
    {
        $course = $this->course->showWithSlug($slug);
        $userCourse = UserCourse::query()
            ->where([
                'course_id' => $course->id,
                'user_id' => $user_id,
            ])
            ->firstOrFail();
        $userCourse->update(['has_downloaded' => 1]);
        $pdf = Pdf::loadView('certificate', compact('userCourse'))->setPaper('A4', 'landscape');

        return [
            'pdf' => $pdf,
            'userCourse' => $userCourse
        ];
    }
}
