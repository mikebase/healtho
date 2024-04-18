<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Command;

use Healtho\Catalogue\Management\Domain\Product\Group;
use Healtho\Shared\Domain\Command\Command;

class CreateProduct implements Command
{
    public function __construct(
        public Group $group,
        public string $name
    ) {
    }
}
