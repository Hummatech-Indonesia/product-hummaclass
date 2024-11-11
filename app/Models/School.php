<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
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
        'description',
        'phone_number'
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
}
