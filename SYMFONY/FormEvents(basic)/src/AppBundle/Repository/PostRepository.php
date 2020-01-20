<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Post;


class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return Post[]
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p,c,sc')
            ->join('p.sub_category', 'sc')
            ->join('sc.category', 'c')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return Post
     */
    public function getOne(int $id): Post
    {
        return $this->createQueryBuilder('p')
            ->select('p,c,sc')
            ->join('p.sub_category', 'sc')
            ->join('sc.category', 'c')
            ->where('p.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getSingleResult();
    }
}
