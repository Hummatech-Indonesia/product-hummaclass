<?php

namespace App\Models;

use App\Base\Interfaces\HasDetailPayments;
use App\Base\Interfaces\HasDivision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model implements HasDetailPayments
{
    use HasFactory;
    
    /**
     * detailPayments
     *
     * @return HasMany
     */
    public function detailPayments(): HasMany
    {
        return $this->hasMany(DetailPayment::class);
    }
}
