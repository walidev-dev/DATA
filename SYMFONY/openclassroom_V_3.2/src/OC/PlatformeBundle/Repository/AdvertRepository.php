<?php

namespace OC\PlatformeBundle\Repository;

use Doctrine\DBAL\Exception\NonUniqueFieldNameException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{

    public function getAdverts($page, $nbPerPage)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->leftJoin('a.image', 'i')->addSelect('i')
            ->leftJoin('a.categories', 'c')->addSelect('c');
            //->orderBy('a.date','DESC');
        $query = $qb->getQuery();

        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);
        return new Paginator($query, true);
    }

    public function myFindAll()
    {
        $qb = $this->createQueryBuilder('a');
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.id=:id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();

    }

    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->leftJoin('a.categories', 'c')->addSelect('c');
        $qb->where($qb->expr()->in('c.name', $categoryNames));
        $query = $qb->getQuery();
        $query->setMaxResults(2);
        return $query->getResult();
    }

}
