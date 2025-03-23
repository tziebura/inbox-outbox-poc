<?php

namespace App\Shared\EventBus;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

final readonly class SymfonyMessengerEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) { }

    public function publish(DomainEvent $event, array $stamps = []): void
    {
        $this->messageBus->dispatch($event, [
            new TransportNamesStamp($event::getType()),
            ...$stamps,
        ]);
    }
}