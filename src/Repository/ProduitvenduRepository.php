<?php

namespace App\Repository;

use App\Entity\Produitvendu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produitvendu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produitvendu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produitvendu[]    findAll()
 * @method Produitvendu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitvenduRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produitvendu::class);
    }

    // /**
    //  * @return Produitvendu[] Returns an array of Produitvendu objects
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
    public function findOneBySomeField($value): ?Produitvendu
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
