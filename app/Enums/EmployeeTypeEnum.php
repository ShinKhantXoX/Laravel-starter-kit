<?php

namespace App\Enums;

enum EmployeeTypeEnum: string 
{
    case WAITER = "WAITER";
    case CASHER = "CASHER";
    case MANAGER = "MANAGER";
    case ASSISTANT_MANAGER = "ASSISTANT_MANAGER";
    case CLEANER = "CLEANER";
    case LADY = "LADY";
    case LADY_MANAGER = "LADY_MANAGER";
}