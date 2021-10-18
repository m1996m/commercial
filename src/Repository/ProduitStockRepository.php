<?php

namespace App\Repository;

use App\Entity\ProduitStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProduitStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitStock[]    findAll()
 * @method ProduitStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitStock::class);
    }

    // /**
    //  * @return ProduitStock[] Returns an array of ProduitStock objects
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
    public function findOneBySomeField($value): ?ProduitStock
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
