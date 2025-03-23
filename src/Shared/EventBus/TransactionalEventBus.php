<?php

namespace App\Shared\EventBus;

use App\Shared\Outbox\Message;
use DateTimeImmutable;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final readonly class TransactionalEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) { }

    public function publish(DomainEvent $event, array $stamps = []): void
    {
        $this->messageBus->dispatch(new Message(
            Uuid::v4()->toRfc4122(),
            new DateTimeImmutable(),
            get_class($event),
            $event->serialize(),
        ));
    }
}