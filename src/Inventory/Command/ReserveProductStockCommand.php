<?php

namespace App\Inventory\Command;

final readonly class ReserveProductStockCommand
{
    public function __construct(
        public string $productId,
        public int $quantity,
    ) { }
}