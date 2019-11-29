<?php

namespace App\Repository;

use App\Entity\GameStuff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameStuff|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameStuff|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameStuff[]    findAll()
 * @method GameStuff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameStuffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameStuff::class);
    }

    // /**
    //  * @return GameStuff[] Returns an array of GameStuff objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameStuff
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
