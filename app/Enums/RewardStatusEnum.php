<?php

namespace App\Enums;

enum RewardStatusEnum: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case PROCESS = 'process';
    case CONFIRMED = 'confirmed';
    case SUCCESS = 'success';
}
