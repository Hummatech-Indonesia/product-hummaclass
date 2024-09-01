<?php

namespace App\Models;

use App\Base\Interfaces\HasSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model implements HasSubCategory
{
    use HasFactory;


    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
