<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Healtho\Catalogue\Management\Domain\Variant\Variant;
use Healtho\Catalogue\Management\Domain\Variant\VariantRepository;
use Healtho\Catalogue\Management\Domain\Variant\VariantSearch;

class DoctrineVariantRepository extends ServiceEntityRepository implements VariantRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Variant::class);
    }

    public function findOneWith(VariantSearch $parameters): ?Variant
    {
        $qb = $this->createQueryBuilder('v');
        $this->filterResult($qb, $parameters);

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function save(Variant $variant): void
    {
        $this->_em->persist($variant);
        $this->_em->flush();
    }

    private function filterResult(QueryBuilder $qb, VariantSearch $parameters): void
    {
        if (! empty($parameters->id)) {
            $qb->andWhere('v.id = :id')
                ->setParameter('id', $parameters->id);
        }

        if (! empty($parameters->name)) {
            $qb->andWhere('v.name = :name')
                ->setParameter('name', $parameters->name);
        }
    }
}
