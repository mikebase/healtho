<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Domain\Product\Product;
use Healtho\Catalogue\Management\Domain\Product\ProductId;
use Healtho\Catalogue\Management\Domain\Product\ProductRepository;
use Healtho\Shared\Domain\Command\CommandHandler;

class CreateProductHandler implements CommandHandler
{
    use ProductManagementTrait;

    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function handle(CreateProduct $command): void
    {
        $product = Product::create(
            ProductId::random(),
            $command->group,
            $command->name
        );

        $this->checkIfTheSameProductExists($product);

        $this->productRepository->save($product);
    }
}
