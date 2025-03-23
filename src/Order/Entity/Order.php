<?php

namespace App\Order\Entity;

use App\Order\ValueObject\OrderId;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'order_id')]
    private OrderId $id;

    #[ORM\Column(type: 'order_items')]
    private array $items;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeInterface $placedAt;

    public function __construct(OrderId $id, DateTimeInterface $placedAt, array $items)
    {
        $this->id = $id;
        $this->placedAt = $placedAt;
        $this->items = $items;
    }
}