<?php

namespace AppBundle\Repository;


class ApplicationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getApplicationsWithAdvert(int $limit)
    {
        $qb = $this->createQueryBuilder('app')
            ->leftJoin('app.advert', 'ad')
            ->addSelect('ad')
            ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

}
