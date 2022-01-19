<?php

namespace App\Repository;

use App\Entity\RESERVATION;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RESERVATION|null find($id, $lockMode = null, $lockVersion = null)
 * @method RESERVATION|null findOneBy(array $criteria, array $orderBy = null)
 * @method RESERVATION[]    findAll()
 * @method RESERVATION[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RESERVATIONRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RESERVATION::class);
    }

    // /**
    //  * @return RESERVATION[] Returns an array of RESERVATION objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RESERVATION
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
