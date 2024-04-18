<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Healtho\Catalogue\Management\Domain\Variant\Variant;
use Healtho\Catalogue\Management\Infrastructure\Doctrine\DoctrineProductRepository;

#[ORM\Entity(repositoryClass: DoctrineProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(name: '`group`', type: Types::STRING, length: 50, enumType: Group::class)]
    private Group $group;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Variant::class)]
    private Collection $variants;

    private function __construct(ProductId $id, Group $group, string $name)
    {
        $this->id = $id->toString();
        $this->group = $group;
        $this->name = $name;

        $this->variants = new ArrayCollection();
    }

    public static function create(ProductId $id, Group $group, string $name): self
    {
        $product = new self($id, $group, $name);
        $product->validation();

        return $product;
    }

    public function update(Group $group, string $name): self
    {
        $this->group = $group;
        $this->name = $name;
        $this->validation();

        return $this;
    }

    public function getId(): ProductId
    {
        return ProductId::fromString($this->id);
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(Variant $variant): void
    {
        if (! $this->variants->contains($variant)) {
            $this->variants[] = $variant;
        }
    }

    private function validation(): void
    {
        $nameLength = mb_strlen($this->name);

        if ($nameLength < 3 || $nameLength > 50) {
            throw new InvalidProduct();
        }
    }
}
