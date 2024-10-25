<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'rewards';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'points_required'
    ];
    /**
     * Get all of the userRewards for the Reward
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRewards(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }
}
