<?php

namespace App\Shared\Model;

interface DomainMessage
{
    public static function getType(): string;
    public function serialize(): array;
    public static function deserialize(array $data): static;
}