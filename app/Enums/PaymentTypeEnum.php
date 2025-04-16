<?php

namespace App\Enums;

enum PaymentTypeEnum: string 
{
    case CASHIN_ON_BILLING = "CASHIN_ON_BILLING";
    case CASH = "CASH";
    case ONLINE = "ONLINE";
}