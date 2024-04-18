<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Request\Product;

use Healtho\Catalogue\Management\Application\Command\UpdateProduct as Command;
use Healtho\Catalogue\Management\Domain\Product\Group;
use Healtho\Shared\Application\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @object-type DTO
 */
final class UpdateProduct implements Request
{
    #[Assert\Uuid]
    public string $id;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [Group::class, 'values'])]
    public Group $group;

    #[Assert\Length(min: 3, max: 255)]
    #[Assert\NotBlank]
    public string $name;

    public function toCommand(): Command
    {
        return new Command(
            $this->id,
            $this->group,
            $this->name
        );
    }
}
