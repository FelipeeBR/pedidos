<?php

namespace App\Http\Enums;

enum OrderStatus: string
{
    case PENDENTE = 'pending';
    case ENTREGUE = 'delivered';
    case CANCELADO = 'cancelled';
}
