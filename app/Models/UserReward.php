<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_id',
        'message',
        'status'
    ];

    /**
     * Get the user that owns the UserReward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the reward that owns the UserReward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}
