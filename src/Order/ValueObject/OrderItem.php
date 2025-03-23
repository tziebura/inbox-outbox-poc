<?php

namespace App\Order\ValueObject;

final readonly class OrderItem
{
    public function __construct(
        public string $id,
        public string $productId,
        public int $quantity,
    ) { }
}