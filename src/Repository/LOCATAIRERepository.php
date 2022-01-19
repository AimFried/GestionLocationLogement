<?php

namespace App\Repository;

use App\Entity\LOCATAIRE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LOCATAIRE|null find($id, $lockMode = null, $lockVersion = null)
 * @method LOCATAIRE|null findOneBy(array $criteria, array $orderBy = null)
 * @method LOCATAIRE[]    findAll()
 * @method LOCATAIRE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LOCATAIRERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LOCATAIRE::class);
    }

    // /**
    //  * @return LOCATAIRE[] Returns an array of LOCATAIRE objects
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
    public function findOneBySomeField($value): ?LOCATAIRE
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
