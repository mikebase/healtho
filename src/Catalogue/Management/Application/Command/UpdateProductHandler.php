<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Domain\Product\ProductRepository;
use Healtho\Shared\Domain\Command\CommandHandler;

class UpdateProductHandler implements CommandHandler
{
    use CatalogueManagementTrait;
    use ProductManagementTrait;

    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function handle(UpdateProduct $command): void
    {
        $product = $this->findProductById($command->id);
        $product->update($command->group, $command->name);

        $this->checkIfTheSameProductExists($product);

        $this->productRepository->save($product);
    }
}
