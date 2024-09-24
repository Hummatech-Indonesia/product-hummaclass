<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'course_id',
        'invoice_id',
        'fee_amount',
        'amount',
        'invoice_url',
        'expiry_date',
        'paid_amount',
        'payment_channel',
        'payment_method',
        'invoice_status'
    ];
}
