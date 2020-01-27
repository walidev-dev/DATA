<?php

namespace AppBundle\Repository;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }
}
