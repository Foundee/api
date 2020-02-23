<?php

namespace App\Repository;

use App\Entity\Ban;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ban|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ban|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ban[]    findAll()
 * @method Ban[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ban::class);
    }

    // /**
    //  * @return Ban[] Returns an array of Ban objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ban
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
