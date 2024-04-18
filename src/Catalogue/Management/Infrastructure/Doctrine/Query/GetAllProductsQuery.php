<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Infrastructure\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use Healtho\Catalogue\Management\Application\Query\GetAllProducts;
use Healtho\Catalogue\Management\Application\Query\Product;

final readonly class GetAllProductsQuery implements GetAllProducts
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return array|Product[]
     */
    public function getResult(): array
    {
        $query = $this->entityManager->createQuery("
            SELECT p.id, p.group, p.name, COUNT(v.id) as variants_count
            FROM Healtho\Catalogue\Management\Domain\Product\Product p
            LEFT JOIN p.variants v
            GROUP BY p.id
        ");
        $results = $query->getArrayResult();

        return array_map(function (array $row) {
            return new Product(
                $row['id'],
                $row['group']->value,
                $row['name'],
                $row['variants_count']
            );
        }, $results);
    }
}
