<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Request\Product;

use Healtho\Catalogue\Management\Application\Command\CreateProduct as Command;
use Healtho\Catalogue\Management\Domain\Product\Group;
use Healtho\Shared\Application\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @object-type DTO
 */
final class CreateProduct implements Request
{
    #[Assert\NotBlank]
    public Group $group;

    #[Assert\Length(min: 3, max: 50)]
    #[Assert\NotBlank]
    public string $name;

    public function toCommand(): Command
    {
        return new Command(
            $this->group,
            $this->name
        );
    }
}
