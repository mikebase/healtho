<?php

namespace Healtho\Tests\Unit\Catalogue\Management\Domain;

use Healtho\Catalogue\Management\Domain\Product\Group;
use Healtho\Catalogue\Management\Domain\Product\Product;
use Healtho\Catalogue\Management\Domain\Product\ProductId;
use Healtho\Catalogue\Management\Domain\Variant\DuplicatedVariant;
use Healtho\Catalogue\Management\Domain\Variant\InvalidVariant;
use Healtho\Catalogue\Management\Domain\Variant\Variant;
use Healtho\Catalogue\Management\Domain\Variant\VariantId;
use PHPUnit\Framework\TestCase;

class VariantTest extends TestCase
{
    public function test_create_when_data_is_valid_should_create_variant_for_product(): void
    {
        //GIVEN
        $product = $this->aProduct();
        $id = VariantId::fromString('1e40a2da-6682-4467-b977-527b2b1a5777');
        $name = 'Premium';

        //WHEN
        $SUT = Variant::create($product, $id, $name);

        //THEN
        self::assertSame($product, $SUT->getProduct());
        self::assertEquals($id, $SUT->getId());
        self::assertSame($name, $SUT->getName());
    }

    public function test_create_when_name_is_duplicated_should_throw_exception(): void
    {
        //GIVEN
        $product = $this->aProduct();
        $variant = $this->aVariant();
        $product->addVariant($variant);

        $id = VariantId::fromString('d8655faf-0249-4300-98b4-3336c5c60dbd');
        $duplicatedName = 'premium';

        //THEN
        $this->expectException(DuplicatedVariant::class);

        //WHEN
        Variant::create($product, $id, $duplicatedName);
    }

    public function test_update_when_name_is_duplicated_should_throw_exception(): void
    {
        //GIVEN
        $product = $this->aProduct();
        $variant = $this->aVariant();
        $product->addVariant($variant);

        $id = VariantId::fromString('d8655faf-0249-4300-98b4-3336c5c60dbd');
        $name = 'bio';
        $SUT = Variant::create($product, $id, $name);
        $product->addVariant($SUT);

        $duplicatedName = 'premium';

        //THEN
        $this->expectException(DuplicatedVariant::class);

        //WHEN
        $SUT->rename($duplicatedName);
    }

    /**
     * @dataProvider dataNamesProvider
     */
    public function test_create_when_name_is_invalid_should_throw_exception(string $name): void
    {
        //GIVEN
        $id = VariantId::fromString('a6d0c8e2-1e1a-4e8b-8d7e-1f4f9c8f0a54');

        //THEN
        $this->expectException(InvalidVariant::class);

        //WHEN
        Variant::create($this->aProduct(), $id, $name);
    }

    /**
     * @return array<string, array<string>>
     */
    protected function dataNamesProvider(): array
    {
        return [
            'Name is too short' => ['a'],
            'Name is too long' => ['Lorem ipsum dolor sit amet, consectetur adipiscing elit.']
        ];
    }

    /**
     * @return Product
     */
    private function aProduct(): Product
    {
        return Product::create(
            ProductId::fromString('a6d0c8e2-1e1a-4e8b-8d7e-1f4f9c8f0a54'),
            Group::FRUIT,
            'Banan'
        );
    }

    private function aVariant(): Variant
    {
        return Variant::create(
            $this->aProduct(),
            VariantId::fromString('1e40a2da-6682-4467-b977-527b2b1a5777'),
            'Premium'
        );
    }
}