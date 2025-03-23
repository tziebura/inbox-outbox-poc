<?php

namespace App\Shared\MessageBus\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

interface Stamp extends StampInterface
{
    public static function getName(): string;
    public function serialize(): array;
    public static function deserialize(array $data): static;
}