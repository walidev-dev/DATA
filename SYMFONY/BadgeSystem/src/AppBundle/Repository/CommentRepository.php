<?php

namespace AppBundle\Repository;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->select('c,u')
            ->join('c.user', 'u')
            ->getQuery()
            ->getResult();
    }

    public function countForUser(int $user_id): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.user = :id')
            ->setParameter('id', $user_id)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
