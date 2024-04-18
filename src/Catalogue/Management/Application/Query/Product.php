<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Query;

/**
 * @object-type DTO
 */
final readonly class Product
{
    public function __construct(
        public string $id,
        public string $group,
        public string $name,
        public int $variantsCount
    ) {
    }
}
