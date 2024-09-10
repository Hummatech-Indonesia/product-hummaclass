<?php

namespace App\Observers;

use App\Models\CourseVoucher;
use Faker\Provider\Uuid;

class CourseVoucherObserver
{
    public function creating(CourseVoucher $courseVoucher): void
    {
        $courseVoucher->id = Uuid::uuid();
    }
}
