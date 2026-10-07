<?php

namespace App\Enums;

enum AvailabilityStatus: string
{
    case ReadyStock = 'ready_stock';
    case PreOrder = 'pre_order';
    case OutOfStock = 'out_of_stock';
}
