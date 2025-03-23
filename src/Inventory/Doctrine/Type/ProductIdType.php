<?php

namespace App\Inventory\Doctrine\Type;

use App\Inventory\ValueObject\ProductId;
use App\Shared\Doctrine\Type\UuidType;

final class ProductIdType extends UuidType
{

    protected function fromString(string $value): \Stringable
    {
        return ProductId::fromString($value);
    }

    public function getName(): string
    {
        return 'product_id';
    }
}