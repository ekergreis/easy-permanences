<?php

namespace App\Repository;

use App\Entity\EchangePropos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EchangePropos|null find($id, $lockMode = null, $lockVersion = null)
 * @method EchangePropos|null findOneBy(array $criteria, array $orderBy = null)
 * @method EchangePropos[]    findAll()
 * @method EchangePropos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EchangeProposRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EchangePropos::class);
    }

    // /**
    //  * @return EchangePropos[] Returns an array of EchangePropos objects
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
    public function findOneBySomeField($value): ?EchangePropos
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
