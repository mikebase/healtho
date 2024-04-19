<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Application\Query\VariantSearch;
use Healtho\Catalogue\Management\Domain\NotFound;
use Healtho\Catalogue\Management\Domain\Variant\Variant;
use Healtho\Catalogue\Management\Domain\Variant\VariantRepository;

class UpdateVariantHandler
{
    public function __construct(
        private readonly VariantRepository $variantRepository
    ) {
    }

    public function handle(UpdateVariant $command): void
    {
        $variant = $this->getVariant($command->id);
        $variant->rename($command->name);

        $this->variantRepository->save($variant);
    }

    private function getVariant(string $id): Variant
    {
        $variant = $this->variantRepository->findOneWith(new VariantSearch(id: $id));

        if (! $variant) {
            throw new NotFound('Variant not found');
        }

        return $variant;
    }
}
