<?php

namespace App\Inventory\Repository;

use App\Inventory\Entity\StockReservation;

interface StockReservationRepository
{
    public function save(StockReservation $stockReservation): void;
}