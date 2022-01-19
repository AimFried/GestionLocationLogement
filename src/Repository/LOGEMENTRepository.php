<?php

namespace App\Repository;

use App\Entity\LOGEMENT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LOGEMENT|null find($id, $lockMode = null, $lockVersion = null)
 * @method LOGEMENT|null findOneBy(array $criteria, array $orderBy = null)
 * @method LOGEMENT[]    findAll()
 * @method LOGEMENT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LOGEMENTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LOGEMENT::class);
    }

    // /**
    //  * @return LOGEMENT[] Returns an array of LOGEMENT objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LOGEMENT
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
