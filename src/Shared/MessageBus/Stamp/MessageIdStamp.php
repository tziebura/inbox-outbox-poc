<?php

namespace App\Shared\MessageBus\Stamp;

final readonly class MessageIdStamp implements Stamp
{
    public function __construct(
        public string $messageId
    ) { }

    public static function getName(): string
    {
        return 'message_id';
    }

    public function serialize(): array
    {
        return [
            'messageId' => $this->messageId,
        ];
    }

    public static function deserialize(array $data): static
    {
        return new self($data['messageId']);
    }
}