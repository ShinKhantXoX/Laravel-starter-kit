<?php

namespace App\Enums;

enum OrderItemStatusEnum: string
{
    case CONFIRM = "CONFIRM";
    case REJECT = "REJECT";
}