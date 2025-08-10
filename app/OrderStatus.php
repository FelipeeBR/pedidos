<?php

namespace App;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
