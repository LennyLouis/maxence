<?php

namespace App\Repository;

use App\Entity\Prognostic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prognostic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prognostic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prognostic[]    findAll()
 * @method Prognostic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrognosticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prognostic::class);
    }

    // /**
    //  * @return Prognostic[] Returns an array of Prognostic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prognostic
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
