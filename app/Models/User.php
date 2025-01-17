<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Base\Interfaces\HasCourseReviews;
use App\Base\Interfaces\HasEventUsers;
use App\Base\Interfaces\HasOneStudent;
use App\Base\Interfaces\HasPayments;
use Laravel\Sanctum\HasApiTokens;
use App\Base\Interfaces\HasUserCourses;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Base\Interfaces\HasSocialAccount;
use App\Base\Interfaces\HasUserCourseTests;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasUserCourses, HasSocialAccount, MustVerifyEmail, HasUserCourseTests, HasCourseReviews, HasOneStudent, HasPayments
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'banner',
        'email',
        'password',
        'point',
        'gender',
        'phone_number',
        'address',
        'photo',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the userRewards for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRewards(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }
    /**
     * Get all of the userCourses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCourses(): HasMany
    {
        return $this->hasMany(UserCourse::class);
    }
    /**
     * Get all of the userCourseTests for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCourseTests(): HasMany
    {
        return $this->hasMany(UserCourseTest::class);
    }
    /**
     * Get all of the courseReviews for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }
    /**
     * Get all of the userEvents for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userEvents(): HasMany
    {
        return $this->hasMany(UserEvent::class);
    }

    /**
     * student
     *
     * @return HasOne
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the mentor associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mentor(): HasOne
    {
        return $this->hasOne(Mentor::class);
    }

    /**
     * payments
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
