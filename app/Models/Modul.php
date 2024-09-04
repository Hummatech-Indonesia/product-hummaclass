<?php

namespace App\Models;

use App\Base\Interfaces\HasCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modul extends Model implements HasCourse
{
    use HasFactory;

    public $keyType = 'char';
    protected $table = 'moduls';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'title', 'sub_title'];
    /**
     * course
     *
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
