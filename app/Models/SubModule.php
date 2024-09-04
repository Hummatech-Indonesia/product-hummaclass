<?php

namespace App\Models;

use App\Base\Interfaces\HasModule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubModule extends Model implements HasModule
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
    /**
     * Get the module that owns the SubModule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
