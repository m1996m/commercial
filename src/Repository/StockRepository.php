<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Stock|null rechercherStock($value)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
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
    public function findOneBySomeField($value): ?Stock
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //Recherche stock
    public function rechercherStock($value)
    {
        return $this->createQueryBuilder('s')
            ->Where('s.nom = :nom')
            ->setParameter('nom', $value)
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Recherche stock
    public function verificationNom($value,Centre $centre)
    {
        return $this->createQueryBuilder('s')
            ->Where('s.nom = :nom')
            ->where('s.centre=:centre')
            ->setParameters(['nom'=>$value,'centre'=>$centre])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll(Centre $centre)
    {
        return $this->createQueryBuilder('s')
            ->join('s.centre','centre')
            ->Where('s.centre = :centre')
            ->select("s.nom,s.adresse,s.id,centre.id,centre.nom")
            ->setParameter('centre', $centre)
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
