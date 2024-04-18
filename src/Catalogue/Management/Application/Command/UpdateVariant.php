<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Shared\Domain\Command\Command;

class UpdateVariant implements Command
{
    public function __construct(
        public string $id,
        public string $name
    ) {
    }
}
