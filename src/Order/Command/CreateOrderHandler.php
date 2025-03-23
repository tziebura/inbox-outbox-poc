<?php

namespace App\Order\Command;

use App\Order\Entity\Order;
use App\Order\Event\Publisher;
use App\Order\Repository\OrderRepository;
use App\Order\ValueObject\OrderId;
use App\Shared\EventBus\EventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateOrderHandler
{
    public function __construct(
        private OrderRepository $orderRepository,
        private Publisher $publisher,
    ) { }

    public function __invoke(CreateOrderCommand $command): void
    {
        $order = new Order(
            OrderId::fromString($command->id),
            $command->placedAt,
            $command->items,
        );

        $this->orderRepository->save($order);

        $this->publisher->publishOrderCreated(
            $command->id,
            $command->placedAt,
            $command->items,
        );
    }
}