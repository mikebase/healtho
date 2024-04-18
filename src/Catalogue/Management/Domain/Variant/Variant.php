<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Variant;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Healtho\Catalogue\Management\Domain\Product\Product;
use Healtho\Catalogue\Management\Infrastructure\Doctrine\DoctrineVariantRepository;
use Healtho\Shared\Infrastructure\UUID;

#[ORM\Entity(repositoryClass: DoctrineVariantRepository::class)]
#[ORM\Table(name: 'product_variant')]
class Variant
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'variants')]
    private Product $product;

    private function __construct(Product $product, UUID $variantId, string $name)
    {
        $this->id = $variantId->toString();
        $this->name = $name;
        $this->product = $product;
    }

    public static function create(Product $product, UUID $variantId, string $name): self
    {
        $self = new self($product, $variantId, $name);
        $self->validation($product, $name);

        return $self;
    }

    public function rename(string $name): void
    {
        $this->name = $name;
        $this->validation($this->getProduct(), $name);
    }

    public function getId(): VariantId
    {
        return VariantId::fromString($this->id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    private function validation(Product $product, string $name): void
    {
        $nameLength = mb_strlen($name);

        if ($nameLength < 3 || $nameLength > 50) {
            throw new InvalidVariant();
        }

        $this->validateDuplications($product, $name);
    }

    private function validateDuplications(Product $product, string $name): void
    {
        $product->getVariants()->map(function (Variant $variant) use ($name) {
            if (! $variant->getId()->equal($this->getId()) &&
                strcasecmp($variant->getName(), $name) === 0) {
                throw new DuplicatedVariant(sprintf('Variant with name %s already exists', $name));
            }
        });
    }
}
