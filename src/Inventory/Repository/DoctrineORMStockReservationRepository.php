<?php

namespace App\Inventory\Repository;

use App\Inventory\Entity\StockReservation;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineORMStockReservationRepository implements StockReservationRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function save(StockReservation $stockReservation): void
    {
        $this->entityManager->persist($stockReservation);
        $this->entityManager->flush();
    }
}