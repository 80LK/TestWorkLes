<?php

namespace App\Repository;

use App\Entity\WoodSpecies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WoodSpecies|null find($id, $lockMode = null, $lockVersion = null)
 * @method WoodSpecies|null findOneBy(array $criteria, array $orderBy = null)
 * @method WoodSpecies[]    findAll()
 * @method WoodSpecies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WoodSpeciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WoodSpecies::class);
    }

    // /**
    //  * @return WoodSpecies[] Returns an array of WoodSpecies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WoodSpecies
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
