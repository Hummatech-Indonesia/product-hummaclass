<?php

namespace App\Models;

use App\Base\Interfaces\HasClassrooms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model implements HasClassrooms
{
    use HasFactory;
    protected $fillable = ['school_year'];

    /**
     * classrooms
     *
     * @return HasMany
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
