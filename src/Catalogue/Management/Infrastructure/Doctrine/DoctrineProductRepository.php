<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Healtho\Catalogue\Management\Application\Query\ProductSearch;
use Healtho\Catalogue\Management\Domain\Product\Product;
use Healtho\Catalogue\Management\Domain\Product\ProductRepository;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function findOneWith(ProductSearch $parameters): ?Product
    {
        $qb = $this->createQueryBuilder('p');
        $this->filterResult($qb, $parameters);

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findWith(ProductSearch $parameters): array
    {
        $qb = $this->createQueryBuilder('p');

        $this->filterResult($qb, $parameters);

        return $qb->getQuery()->getResult();
    }

    private function filterResult(QueryBuilder $qb, ProductSearch $parameters): void
    {
        if (! empty($parameters->id)) {
            $qb->andWhere('p.id = :id')
                ->setParameter('id', $parameters->id);
        }

        if (! empty($parameters->name)) {
            $qb->andWhere('p.name = :name')
                ->setParameter('name', $parameters->name);
        }

        if (! empty($parameters->group)) {
            $qb->andWhere('p.group = :group')
                ->setParameter('group', $parameters->group);
        }
    }
}
