<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Request\Variant;

use Healtho\Catalogue\Management\Application\Command\UpdateVariant as Command;
use Healtho\Shared\Application\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @object-type DTO
 */
final class UpdateVariant implements Request
{
    #[Assert\Uuid]
    public string $id;

    #[Assert\Length(min: 3, max: 255)]
    public string $name;

    public function toCommand(): Command
    {
        return new Command(
            $this->id,
            $this->name
        );
    }
}
