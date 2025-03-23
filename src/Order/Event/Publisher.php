<?php

namespace App\Order\Event;

use App\Shared\EventBus\EventBus;

final readonly class Publisher
{
    public function __construct(
        private EventBus $eventBus,
    ) { }

    public function publishOrderCreated(string $id, \DateTimeImmutable $placedAt, array $items): void
    {
        $this->eventBus->publish(new OrderCreated($id, $placedAt, $items));
    }
}