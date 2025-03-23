<?php

namespace App\Shared\Inbox;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'inbox')]
final class Message
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $receivedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $processedAt;

    public function __construct(string $id, DateTimeImmutable $receivedAt, DateTimeImmutable $processedAt)
    {
        $this->id = $id;
        $this->receivedAt = $receivedAt;
        $this->processedAt = $processedAt;
    }
}