<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperiorFeature extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'mentor', 'course', 'task'];
}
