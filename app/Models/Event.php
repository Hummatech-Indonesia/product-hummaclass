<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'title',
        'description',
        'location',
        'capacity',
        'price',
        'start_date',
        'has_certificate',
        'is_online',
    ];
}
