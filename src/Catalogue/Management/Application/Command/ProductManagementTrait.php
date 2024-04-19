<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Application\Query\ProductSearch;
use Healtho\Catalogue\Management\Domain\Product\DuplicatedProduct;
use Healtho\Catalogue\Management\Domain\Product\Product;

trait ProductManagementTrait
{
    private function checkIfTheSameProductExists(Product $new): void
    {
        $existed = $this->productRepository->findOneWith(new ProductSearch(
            name: $new->getName(),
            group: $new->getGroup()->value
        ));

        if ($existed && ! $existed->getId()->equal($new->getId())) {
            throw new DuplicatedProduct('Product with the same name and group already exists');
        }
    }
}
