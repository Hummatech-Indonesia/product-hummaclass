<?php

namespace App\Models;

use App\Base\Interfaces\HasClassrooms;
use App\Base\Interfaces\HasZooms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model implements HasZooms, HasClassrooms
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'address',
        'head_master',
        'photo',
        'payment_method',
        'description',
        'phone_number',
        'npsn',
        'email'
    ];
    /**
     * Get all of the classrooms for the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    /**
     * Get all of the comments for the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zooms(): HasMany
    {
        return $this->hasMany(Zoom::class);
    }
}
