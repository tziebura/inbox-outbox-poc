<?php

namespace App\Shared\ValueObject;

use Override;
use Stringable;
use Symfony\Component\Uid\Uuid;

abstract class ObjectId implements Stringable
{
    private function __construct(
        public Uuid $id
    ) { }

    public static function newOne(): self
    {
        return new static(Uuid::v7());
    }

    public static function fromString(string $id): static
    {
        return new static(Uuid::fromString($id));
    }

    public function toString(): string
    {
        return $this->id->toRfc4122();
    }

    #[Override]
    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(mixed $other): bool
    {
        if (!$other instanceof static) {
            return false;
        }

        return self::class === $other::class && $this->id->equals($other->id);
    }
}