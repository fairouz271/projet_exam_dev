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


        public function findAverageRatingByCenter(Center $center): Float
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
