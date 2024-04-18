<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Request\Variant;

use Healtho\Catalogue\Management\Application\Command\CreateVariant as Command;
use Healtho\Shared\Application\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @object-type DTO
 */
final class CreateVariant implements Request
{
    #[Assert\Uuid]
    public string $productId;

    #[Assert\Length(min: 3, max: 50)]
    public string $name;

    public function toCommand(): Command
    {
        return new Command(
            $this->productId,
            $this->name
        );
    }
}
