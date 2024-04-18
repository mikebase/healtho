<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Variant;

interface VariantRepository
{
    public function findOneWith(VariantSearch $parameters): ?Variant;

    public function save(Variant $variant): void;
}
