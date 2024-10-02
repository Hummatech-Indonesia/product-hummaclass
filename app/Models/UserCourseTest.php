<?php

namespace App\Models;

use App\Base\Interfaces\HasCourseTest;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCourseTest extends Model implements HasCourseTest, HasUser
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'user_course_tests';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'course_id',
        'module_question_id',
        'answer',
        'score',
    ];
    /**
     * Get the user that owns the UserCourseTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the courseTest that owns the UserCourseTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTest(): BelongsTo
    {
        return $this->belongsTo(CourseTest::class);
    }
}
