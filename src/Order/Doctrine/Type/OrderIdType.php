<?php

namespace App\Order\Doctrine\Type;

use App\Order\ValueObject\OrderId;
use App\Shared\Doctrine\Type\UuidType;

final class OrderIdType extends UuidType
{

    protected function fromString(string $value): \Stringable
    {
        return OrderId::fromString($value);
    }

    public function getName(): string
    {
        return 'order_id';
    }
}