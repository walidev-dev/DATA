<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string|null $tagName
     * @return Post[]|null
     */
    public function getAll(string $tagName = null): ?array
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.tags', 't')->addSelect('t')
            ->leftJoin('p.tags','tmp');
        if (null !== $tagName) {
            $query->andWhere('tmp.name = :tagName');
            $query->setParameter('tagName', $tagName);
        }
        return $query->getQuery()->getResult();
    }
}
