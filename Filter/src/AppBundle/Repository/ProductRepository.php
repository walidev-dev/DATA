<?php

namespace AppBundle\Repository;

use AppBundle\Data\SearchData;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param SearchData $searchData
     * @return \Doctrine\ORM\Query
     */
    public function findSearchQuery(SearchData $searchData)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p,c')
            ->join('p.categories', 'c');

        if (!empty($searchData->q)) {
            $query = $query
                ->andWhere('p.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }

        if (!empty($searchData->categories)) {
            $query = $query
                ->andWhere('c.id IN(:categories)')
                ->setParameter('categories', $searchData->categories);
        }

        if (!empty($searchData->min)) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $searchData->min);
        }

        if (!empty($searchData->max)) {
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $searchData->max);
        }

        if (!empty($searchData->promo)) {
            $query = $query
                ->andWhere('p.promo = 1');
        }

        return $query->getQuery();
    }

    /**
     * @return integer[]
     */
    public function findMinMax(): array
    {
        $results = $this->createQueryBuilder('p')
            ->select('MIN(p.price), MAX(p.price)')
            ->getQuery()
            ->getScalarResult();

        return [(int)$results[0][1], (int)$results[0][2]];
    }
}
