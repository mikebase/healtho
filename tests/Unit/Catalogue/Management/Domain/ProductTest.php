<?php

namespace Healtho\Tests\Unit\Catalogue\Management\Domain;

use Healtho\Catalogue\Management\Domain\Product\Group;
use Healtho\Catalogue\Management\Domain\Product\InvalidProduct;
use Healtho\Catalogue\Management\Domain\Product\Product;
use Healtho\Catalogue\Management\Domain\Product\ProductId;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function test_create_when_data_is_valid_should_create_product(): void
    {
        //GIVEN
        $id = ProductId::fromString('a6d0c8e2-1e1a-4e8b-8d7e-1f4f9c8f0a54');
        $group = Group::FRUIT;
        $name = 'Banan';

        //WHEN
        $SUT = Product::create($id, $group, $name);

        //THEN
        self::assertEquals($id, $SUT->getId());
        self::assertSame($group, $SUT->getGroup());
        self::assertSame($name, $SUT->getName());
    }

    public function test_update_when_data_is_valid_should_update_product(): void
    {
        //GIVEN
        $id = ProductId::fromString('a6d0c8e2-1e1a-4e8b-8d7e-1f4f9c8f0a54');
        $group = Group::FRUIT;
        $name = 'Jabłko';

        $SUT = Product::create($id, $group, $name);

        $newGroup = Group::VEGETABLE;
        $newName = 'Marchew';

        //WHEN
        $SUT->update($newGroup, $newName);

        //THEN
        self::assertSame($newGroup, $SUT->getGroup());
        self::assertSame($newName, $SUT->getName());
    }

    /**
     * @dataProvider dataNamesProvider
     */
    public function test_create_when_name_is_invalid_should_throw_exception(string $name): void
    {
        //GIVEN
        $id = ProductId::fromString('a6d0c8e2-1e1a-4e8b-8d7e-1f4f9c8f0a54');
        $group = Group::FRUIT;

        //THEN
        $this->expectException(InvalidProduct::class);

        //WHEN
        Product::create($id, $group, $name);
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
}