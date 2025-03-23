<?php

namespace App\Order\Command;

use App\Order\ValueObject\OrderItem;

final readonly class CreateOrderCommand
{
    public function __construct(
        public string $id,
        public \DateTimeImmutable $placedAt,
        /** @var OrderItem[] */
        public array $items,
    ) { }
}