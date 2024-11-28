<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';
    case GUEST = 'guest';
    case TEACHER = 'teacher';
    case MENTOR = 'mentor';
}
