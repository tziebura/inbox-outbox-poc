<?php

namespace App\Shared\EventBus;

use App\Shared\MessageBus\Stamp\Stamp;

interface EventBus
{
    /**
     * @param Stamp[] $stamps
     */
    public function publish(DomainEvent $event, array $stamps = []): void;
}