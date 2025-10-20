<?php

namespace App\Repository;

use App\Entity\Center;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Center>
 */
class CenterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Center::class);
    }

    public function findCenterById(int $id): ?Center
    {
        return $this->find($id);
    }
    public function findByNameOrAdress(?string $query)
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.adress', 'a')
            ->addSelect('a');

        if ($query) {
            $qb->where('c.name LIKE :q OR a.adress LIKE :q')
            ->setParameter('q', '%'.$query.'%');
        }

        return $qb->getQuery()->getResult();
    }

}
