<?php

namespace App\Models;

use App\Base\Interfaces\HasCourse;
use App\Base\Interfaces\HasSubModules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model implements HasCourse, HasSubModules
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'modules';
    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'sub_title'
    ];

    /**
     * Get the course that owns the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    /**
     * Get all of the subModules for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subModules(): HasMany
    {
        return $this->hasMany(SubModule::class);
    }

}
