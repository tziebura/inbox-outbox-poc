<?php

namespace App\Shared\Outbox;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('outbox')]
final readonly class Message
{
    public function __construct(
        public string $id,
        public DateTimeImmutable $occurredAt,
        public string $messageClass,
        public array $payload,
    ) { }
}