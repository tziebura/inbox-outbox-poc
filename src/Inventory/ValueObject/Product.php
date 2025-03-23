<?php

namespace App\Inventory\ValueObject;

final readonly class Product
{
    public function __construct(
        public string $id,
        public int $quantity,
    ) { }
}