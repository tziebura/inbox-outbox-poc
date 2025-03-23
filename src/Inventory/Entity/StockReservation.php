<?php

namespace App\Inventory\Entity;

use App\Inventory\ValueObject\ProductId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class StockReservation
{
    #[ORM\Id]
    #[ORM\Column(type: 'product_id')]
    private ProductId $productId;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function __construct(ProductId $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }


}