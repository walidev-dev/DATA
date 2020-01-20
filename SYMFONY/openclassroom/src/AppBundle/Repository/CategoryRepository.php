<?php

namespace AppBundle\Repository;

class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLikeQueryBuilder($pattern)
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :pattern')
            ->setParameter('pattern', $pattern);
    }
}
