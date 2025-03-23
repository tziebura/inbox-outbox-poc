<?php

namespace App\Order\Doctrine\Type;

use App\Order\ValueObject\OrderItem;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

final class OrderItemsType extends JsonType
{
    /**
     * @param OrderItem[] $value
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $items = [];

        foreach ($value as $item) {
            $items[] = [
                'itemId' => $item->id,
                'productId' => $item->productId,
                'quantity' => $item->quantity,
            ];
        }

        return parent::convertToDatabaseValue($items, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $value = parent::convertToPHPValue($value, $platform);

        $items = [];

        foreach ($value as $item) {
            $items[] = new OrderItem(
                $item['itemId'],
                $item['productId'],
                $item['quantity'],
            );
        }

        return $items;
    }

    public function getName(): string
    {
        return 'order_items';
    }
}