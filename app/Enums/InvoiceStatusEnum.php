<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case PAID = 'paid';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
    case UNPAID = 'unpaid';
}
