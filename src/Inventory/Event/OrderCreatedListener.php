<?php

namespace App\Inventory\Event;

use App\Inventory\Command\ReserveProductStockCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler('event_bus')]
final readonly class OrderCreatedListener
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) { }

    public function __invoke(OrderCreated $event): void
    {
        foreach ($event->items as $item) {
            $this->messageBus->dispatch(new ReserveProductStockCommand(
                $item->id,
                $item->quantity,
            ));
        }
    }
}