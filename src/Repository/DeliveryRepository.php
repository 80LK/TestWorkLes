<?php

namespace App\Repository;

use App\Entity\Delivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Delivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivery[]    findAll()
 * @method Delivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    public function findSortBy(array $orders = ["id" => "ASC"], int $limit = 10, int $offset = 0)
    {
        $joined = [];
        $query = $this->createQueryBuilder("d")
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        foreach ($orders as $field => $order) {
            $fieldSet = explode(".", $field);

            if(isset($fieldSet[1])){
                if(!in_array($fieldSet[0], $joined)){
                    $query->join("d." . $fieldSet[0], $fieldSet[0]);
                    $joined[] = $fieldSet[0];
                }

                $query->orderBy($field, $order);
            }else{
                $query->orderBy("d." . $field, $order);
            }
        }

        return $query->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Delivery[] Returns an array of Delivery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Delivery
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
