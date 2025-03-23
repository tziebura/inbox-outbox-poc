<?php

namespace App\Order\Event;

use App\Order\ValueObject\OrderItem;
use App\Shared\EventBus\DomainEvent;
use DateTimeImmutable;

final readonly class OrderCreated extends DomainEvent
{
    public function __construct(
        public string $orderId,
        public DateTimeImmutable $placedAt,
        /** @var OrderItem[] */
        public array $items,
    ) { }

    public static function getType(): string
    {
        return 'order.event.order_created';
    }

    public function serialize(): array
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = [
                'id' => $item->id,
                'productId' => $item->productId,
                'quantity' => $item->quantity,
            ];
        }

        return [
            'orderId' => $this->orderId,
            'placedAt' => $this->placedAt->getTimestamp(),
            'items' => $items,
        ];
    }

    public static function deserialize(array $data): static
    {
        $items = [];

        foreach ($data['items'] as $item) {
            $items[] = new OrderItem(
                $item['id'],
                $item['productId'],
                $item['quantity'],
            );
        }

        return new self(
            $data['orderId'],
            new DateTimeImmutable('@' . $data['placedAt']),
            $items,
        );
    }
}