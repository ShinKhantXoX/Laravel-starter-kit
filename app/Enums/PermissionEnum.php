<?php

namespace App\Enums;

enum PermissionEnum: string
{

    /** USER */
    case USER_INDEX = 'USER_INDEX';
    case USER_SHOW = 'USER_SHOW';
    case USER_STORE = 'USER_STORE';
    case USER_UPDATE = 'USER_UPDATE';
    case USER_DESTROY = 'USER_DESTROY';
    case USER_EXPORT = 'USER_EXPORT';

    case COUNTER_INDEX = "COUNTER_INDEX";
}