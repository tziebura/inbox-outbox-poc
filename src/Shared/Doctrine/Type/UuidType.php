<?php

namespace App\Shared\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class UuidType extends Type
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        \assert($value instanceof \Stringable);

        return $value->__toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\Stringable
    {
        if ($value === null) {
            return null;
        }

        \assert(\is_string($value));

        return $this->fromString($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    abstract protected function fromString(string $value): \Stringable;

    public abstract function getName(): string;
}