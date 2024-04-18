<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Domain\Product\ProductRepository;
use Healtho\Catalogue\Management\Domain\Variant\Variant;
use Healtho\Catalogue\Management\Domain\Variant\VariantId;
use Healtho\Catalogue\Management\Domain\Variant\VariantRepository;
use Healtho\Shared\Domain\Command\CommandHandler;

class CreateVariantHandler implements CommandHandler
{
    use CatalogueManagementTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly VariantRepository $variantRepository,
    ) {
    }

    public function handle(CreateVariant $command): void
    {
        $product = $this->findProductById($command->productId);
        $variant = Variant::create($product, VariantId::random(), $command->name);

        $this->variantRepository->save($variant);
    }
}
