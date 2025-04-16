<?php

namespace App\Enums;

enum  RoleTypeEnum: string
{
    case ROOT = "ROOT";
    case SUPER_ADMIN = "SUPER_ADMIN";
    case MANAGER = "MANAGER";
    case CASHEAR = "CASHEAR";
}