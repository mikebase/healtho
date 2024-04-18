<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Shared\Domain\Command\Command;

class CreateVariant implements Command
{
    public function __construct(
        public string $productId,
        public string $name
    ) {
    }
}
