<?php

namespace App\Shared\MessageBus\Stamp;

final readonly class MessageTypeStamp implements Stamp
{
    public function __construct(
        public string $type,
    ) { }

    public static function getName(): string
    {
        return 'message_type';
    }

    public function serialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    public static function deserialize(array $data): static
    {
        return new self($data['type']);
    }

    public function getType(): string
    {
        return $this->type;
    }
}