<?php

namespace App\Repository;

use App\Entity\AdminForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminForm[]    findAll()
 * @method AdminForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminForm::class);
    }

    // /**
    //  * @return AdminForm[] Returns an array of AdminForm objects
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
    public function findOneBySomeField($value): ?AdminForm
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
