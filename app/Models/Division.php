<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'divisions';
    protected $fillable = [
        'name'
    ];
    /**
     * Get all of the classrooms for the Division
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
