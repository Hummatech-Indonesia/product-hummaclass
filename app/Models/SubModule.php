<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $table = 'sub_modules';
    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'subtitle',
        'content',
        'url_youtube'
    ];
}
