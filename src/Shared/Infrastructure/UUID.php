<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure;

use Healtho\Shared\Domain\InvalidId;
use Ramsey\Uuid\Uuid as RamseyUuid;

class UUID
{
    private const PATTERN = '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/';

    final public function __construct(
        private readonly string $value
    ) {
        if (! \preg_match(self::PATTERN, $this->value)) {
            throw new InvalidId();
        }
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public static function random(): static
    {
        return new static(RamseyUuid::getFactory()->uuid4()->toString());
    }

    public function equal(self $other): bool
    {
        return static::class === $other::class && $this->value === $other->value;
    }
}
