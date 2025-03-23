<?php

namespace App\Order\Repository;

use App\Order\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineORMOrderRepository implements OrderRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) { }

    public function save(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}