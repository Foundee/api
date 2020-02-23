<?php

namespace App\Repository;

use App\Entity\AdminAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdminAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminAction[]    findAll()
 * @method AdminAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminAction::class);
    }

    // /**
    //  * @return AdminAction[] Returns an array of AdminAction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminAction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
