<?php

namespace App\Repository;

use App\Entity\Center;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findByCenterQuery(Center $center)
    {
        return $this->createQueryBuilder('c')
            ->where('c.center = :center')
            ->andWhere('c.isApproved = true')
            ->setParameter('center', $center)
            ->orderBy('c.publicationDate', 'DESC')
            ->getQuery();
    }
        public function findAverageRatingByCenter(Center $center): float
        {
            return $this->createQueryBuilder('r')
                ->select('AVG(r.rating) as averageRating')
                ->Where('r.center = :center')
                ->setParameter('center', $center)
                ->getQuery()
                ->getSingleScalarResult()
            ;
        }
}
