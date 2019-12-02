<?php

namespace App\Repository;

use App\Entity\JobName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobName|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobName|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobName[]    findAll()
 * @method JobName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobName::class);
    }

    // /**
    //  * @return JobName[] Returns an array of JobName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobName
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
