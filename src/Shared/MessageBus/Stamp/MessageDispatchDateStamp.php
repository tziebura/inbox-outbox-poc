<?php

namespace App\Shared\MessageBus\Stamp;

use DateTimeImmutable;

final readonly class MessageDispatchDateStamp implements Stamp
{
    public function __construct(
        public DateTimeImmutable $dispatchDate,
    ) { }

    public static function getName(): string
    {
        return 'message_dispatch_date';
    }

    public function serialize(): array
    {
        return [
            'dispatchDate' => $this->dispatchDate->getTimestamp(),
        ];
    }

    public static function deserialize(array $data): static
    {
        return new self(
            new DateTimeImmutable('@' . $data['dispatchDate']),
        );
    }
}