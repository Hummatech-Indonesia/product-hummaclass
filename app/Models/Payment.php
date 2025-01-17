<?php

namespace App\Models;

use App\Base\Interfaces\HasDetailPayments;
use App\Base\Interfaces\HasDivision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model implements HasDetailPayments
{
    use HasFactory;
    protected $fillable = ['reference', 'user_id', 'invoice_id', 'fee_amount', 'amount', 'expiry_date', 'paid_amount', 'payment_channel', 'payment_method', 'invoice_status'];

    /**
     * detailPayments
     *
     * @return HasMany
     */
    public function detailPayments(): HasMany
    {
        return $this->hasMany(DetailPayment::class);
    }

    /**
     * Get the user that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
