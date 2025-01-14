<?php

namespace App\Enums;

enum PresenceEnum: string
{
    case PRESENT = 'present';
    case ALPHA = 'alpha';
    case PERMIT = 'permit';
    case SICK = 'sick';
}
