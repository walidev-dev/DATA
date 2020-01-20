<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Option_;
use AppBundle\Entity\Property;
use AppBundle\Entity\PropertySearch;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class PropertyRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function getAllQuery()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery();
    }

    /**
     * @param PropertySearch $search
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.options_', 'op')->addSelect('op')
            ->leftJoin('p.options_', 'o');
        $query->andWhere('p.sold = false');
        if ($search->getMaxPrice()) {
            $query
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()) {
            $query
                ->andWhere('p.surface >= :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }

        if ($search->getOptions()->count() > 0) {
              /* foreach ($search->getOptions() as $k => $v) {
                   $query->andWhere('o.id = :optionId');
                   $query->setParameter('optionId',$v->getId());
               }*/

            foreach ($search->getOptions() as $k => $v) {
                $query
                    ->andWhere(':option MEMBER OF p.options_')
                    ->setParameter('option', $v);
            }

        }
        return $query->getQuery();

    }

    /**
     * @return Property[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findOne($id): ?Property
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.options_', 'o')->addSelect('o')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
