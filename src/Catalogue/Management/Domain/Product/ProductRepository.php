<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Product;

use Healtho\Catalogue\Management\Application\Query\ProductSearch;

interface ProductRepository
{
    public function findOneWith(ProductSearch $parameters): ?Product;

    /**
     * @param ProductSearch $parameters
     * @return array|Product[]
     */
    public function findWith(ProductSearch $parameters): array;

    public function save(Product $product): void;
}
