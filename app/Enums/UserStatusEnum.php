<?php

namespace App\Enums;

enum UserStatusEnum : string
{
    case ACTIVE = "ACTIVE";
    case BLOCK = "BLOCK";
    case SUSPEND = "SUSPEND";
}