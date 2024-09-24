<?php

namespace App\Enums;

enum UploadDiskEnum: string
{
    case USERS = 'users';
    case COURSES = 'courses';
    case EVENTS = 'events';
    case BLOGS = 'blogs';
}
