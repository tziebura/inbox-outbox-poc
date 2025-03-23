<?php

namespace App\Shared\Inbox;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

final readonly class DoctrineORMMessageStore implements MessageStore
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function exists(string $id): bool
    {
        $qb = $this->entityManager->createQueryBuilder();

        try {
            $qb->select('1')
                ->from(Message::class, 'm')
                ->where('m.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

            return true;
        } catch (NoResultException) {
            return false;
        }
    }

    public function save(Message $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }
}