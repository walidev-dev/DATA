<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Advert;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class AdvertRepository extends EntityRepository
{

    public function getLast($limit): array
    {
        $qb = $this->_em->createQueryBuilder()->select("a")->from(Advert::class, "a");
        //$qb->where('a.published = 0');
        $qb->orderBy('a.date', 'DESC')->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

    public function getOne($id): ?Advert
    {
        $qb = $this->_em->createQueryBuilder()->select("a")->from(Advert::class, "a");
        $qb->leftJoin('a.categories', 'cat')->addSelect('cat');
        $qb->leftJoin('a.image', 'image')->addSelect('image');
        $qb->where("a.id = :id")->setParameter("id", $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getAdvertsWithCategories(array $categoryNames)
    {
        $qb = $this->_em->createQueryBuilder()->select('a')->from(Advert::class, 'a');
        $qb->leftJoin('a.categories', 'c')->addSelect('c');
        $qb->where($qb->expr()->in('c.name', $categoryNames));
        return $qb->getQuery()->getResult();
    }

    public function getAdverts($Page, $perPage)
    {
        $qb = $this->_em->createQueryBuilder()->select("a")->from(Advert::class, "a");
        $qb->leftJoin('a.categories', 'c')->addSelect('c');
        $qb->leftJoin('a.image', 'i')->addSelect('i');
        $qb->setFirstResult(($Page - 1) * $perPage);
        $qb->setMaxResults($perPage);
        $qb->orderBy('a.date', 'DESC');
        return $qb->getQuery()->getResult();
        //return new Paginator($qb,true);
    }

    public function getAdverts2(int $page, int $perPage)
    {
        return $this->createQueryBuilder('a')
            ->join('a.categories', 'c')
            ->join('a.image', 'i')
            ->select('a,i,c')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->orderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function AdvertsCount()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(a.id)')
            ->from(Advert::class, 'a');
        return (int)$qb->getQuery()->getSingleScalarResult();
    }

}
