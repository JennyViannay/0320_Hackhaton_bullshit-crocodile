<?php

namespace App\Repository;

use App\Entity\ExcuseLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExcuseLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcuseLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcuseLike[]    findAll()
 * @method ExcuseLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcuseLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcuseLike::class);
    }

    // /**
    //  * @return ExcuseLike[] Returns an array of ExcuseLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExcuseLike
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
