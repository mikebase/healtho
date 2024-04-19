<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Query;

final readonly class ProductSearch
{
    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $group = ''
    ) {
    }
}
