<?php

namespace App\Repository;

use App\Entity\Permanence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Permanence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permanence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permanence[]    findAll()
 * @method Permanence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermanenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permanence::class);
    }

    // /**
    //  * @return Permanence[] Returns an array of Permanence objects
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
    public function findOneBySomeField($value): ?Permanence
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
