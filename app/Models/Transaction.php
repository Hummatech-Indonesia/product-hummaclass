<?php

namespace App\Models;

use App\Base\Interfaces\HasCourse;
use App\Base\Interfaces\HasCourseVoucher;
use App\Base\Interfaces\HasEvent;
use App\Base\Interfaces\HasUser;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseVoucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model implements HasUser, HasCourse, HasCourseVoucher, HasEvent, HasCourseVoucher
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'course_id',
        'event_id',
        'invoice_id',
        'fee_amount',
        'amount',
        'invoice_url',
        'expiry_date',
        'paid_amount',
        'payment_channel',
        'payment_method',
        'invoice_status',
        'course_voucher_id'
    ];

    /**
     * Get the user associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the event that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the courseVoucher that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseVoucher(): BelongsTo
    {
        return $this->belongsTo(CourseVoucher::class);
    }
}
