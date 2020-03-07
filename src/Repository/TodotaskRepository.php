<?php

namespace App\Repository;

use App\Entity\Todotask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Todotask|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todotask|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todotask[]    findAll()
 * @method Todotask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodotaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todotask::class);
    }

    // /**
    //  * @return Todotask[] Returns an array of Todotask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Todotask
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
