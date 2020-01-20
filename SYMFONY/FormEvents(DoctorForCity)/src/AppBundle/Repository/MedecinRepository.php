<?php

namespace AppBundle\Repository;


class MedecinRepository extends \Doctrine\ORM\EntityRepository
{
    public function findWithRegion(int $id)
    {
        return $this->createQueryBuilder('m')
            ->select('m,v,d,r')
            ->join('m.ville', 'v')
            ->join('v.departement', 'd')
            ->join('d.region', 'r')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult();
    }

    public function findAllWithRegion()
    {
        return $this->createQueryBuilder('m')
            ->select('m,v,d,r')
            ->join('m.ville', 'v')
            ->join('v.departement', 'd')
            ->join('d.region', 'r')
            ->getQuery()->getResult();
    }
}
