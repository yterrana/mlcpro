<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    // /**
    //  * @return Job[] Returns an array of Job objects
    //  */

    public function searchJobs($criteria)
    {
        $title = $criteria['title'];
        $region = $criteria['region'];

        if (!is_null($title) AND !is_null($region)) {
            $q = $this->createQueryBuilder('j')
                ->where('j.title = :title')
                ->setParameter('title', $title->getId())
                ->andWhere('j.region = :region')
                ->setParameter('region', $region)
                ->orderBy('j.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
            return $q;
        }
        elseif (is_null($region) AND !is_null($title)) {
            $q = $this->createQueryBuilder('j')
                ->where('j.title = :title')
                ->setParameter('title', $title->getId())
                ->orderBy('j.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }
        elseif (!is_null($region) AND is_null($title)) {
            $q = $this->createQueryBuilder('j')
                ->where('j.region = :region')
                ->setParameter('region', $region)
                ->orderBy('j.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }
        else {
            $q = $this->createQueryBuilder('j')
                ->orderBy('j.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        return $q;
    }


    /*
    public function findOneBySomeField($value): ?Job
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
