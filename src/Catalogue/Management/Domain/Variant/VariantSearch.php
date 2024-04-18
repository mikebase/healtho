<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Variant;

final readonly class VariantSearch
{
    public function __construct(
        public string $id = '',
        public string $name = ''
    ) {
    }
}
