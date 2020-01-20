<?php

namespace Grafikart\TagBundle\Repository;
use Doctrine\ORM\EntityRepository;



class TagRepository extends EntityRepository
{
    public function getTagByName(string $name)
    {
        return $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
