<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Application\Query\ProductSearch;
use Healtho\Catalogue\Management\Domain\NotFound;
use Healtho\Catalogue\Management\Domain\Product\Product;

trait CatalogueManagementTrait
{
    protected function findProductById(string $id): Product
    {
        $product = $this->productRepository->findOneWith(new ProductSearch(id: $id));

        if (! $product) {
            throw new NotFound('Product not found');
        }

        return $product;
    }
}
