<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Product;

final readonly class ProductSearch
{
    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $group = ''
    ) {
    }
}
