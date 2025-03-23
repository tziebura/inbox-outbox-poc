<?php

namespace App\Inventory\Event;

use App\Inventory\ValueObject\Product;
use App\Shared\EventBus\DomainEvent;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('inventory.event.order_created')]
final readonly class OrderCreated extends DomainEvent
{
    public function __construct(
        public string $orderId,
        public DateTimeImmutable $placedAt,
        /** @var Product[] */
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
                'productId' => $item->id,
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
            $items[] = new Product(
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