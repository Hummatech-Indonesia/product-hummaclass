<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mentor extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'rekening_number',
        'bank_name',
    ];

    /**
     * Get the user that owns the Mentor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
