<?php

namespace App\Repository;

use App\Entity\Stuff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stuff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stuff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stuff[]    findAll()
 * @method Stuff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StuffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stuff::class);
    }

    public function selectRandomStuffBySlot($slot, $_exclude) {
        
        $rsm = new \Doctrine\ORM\Query\ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(\App\Entity\Stuff::class, 'Stuff');
        $sql = "SELECT * FROM stuff  
        WHERE slot_id = ".$slot->getId(); 
        if(!empty($_exclude)){
            $sql .=" AND id NOT IN (".implode(', ', $_exclude).")";
        }
        $sql .= " ORDER BY RAND() LIMIT 1";
        return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getOneOrNullResult();
    }

    // /**
    //  * @return Stuff[] Returns an array of Stuff objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stuff
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
