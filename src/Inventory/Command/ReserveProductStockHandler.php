<?php

namespace App\Inventory\Command;

use App\Inventory\Entity\StockReservation;
use App\Inventory\Repository\StockReservationRepository;
use App\Inventory\ValueObject\ProductId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ReserveProductStockHandler
{
    public function __construct(
        private StockReservationRepository $stockReservationRepository
    ) { }

    public function __invoke(ReserveProductStockCommand $command): void
    {
        $reservation = new StockReservation(
            ProductId::fromString($command->productId),
            $command->quantity,
        );

        $this->stockReservationRepository->save($reservation);
    }
}