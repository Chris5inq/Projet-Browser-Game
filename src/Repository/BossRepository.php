<?php

namespace App\Repository;

use App\Entity\Boss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Boss|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boss|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boss[]    findAll()
 * @method Boss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BossRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boss::class);
    }

    // /**
    //  * @return Boss[] Returns an array of Boss objects
    //  */
    
    public function selectRandomBoss() {
        $rsm = new \Doctrine\ORM\Query\ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(\App\Entity\Boss::class, 'Boss');
        $sql = "SELECT * FROM Boss ORDER BY RAND() LIMIT 1";
        return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getOneOrNullResult();
    }

    
    

    // /**
    //  * @return Boss[] Returns an array of Boss objects
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
    public function findOneBySomeField($value): ?Boss
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
