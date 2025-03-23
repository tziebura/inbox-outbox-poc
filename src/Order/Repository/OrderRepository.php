<?php

namespace App\Order\Repository;

use App\Order\Entity\Order;

interface OrderRepository
{
    public function save(Order $order): void;
}