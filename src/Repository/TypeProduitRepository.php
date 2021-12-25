<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\TypeProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeProduit[]    findAll()
 * @method TypeProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeProduit::class);
    }

    // /**
    //  * @return TypeProduit[] Returns an array of TypeProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeProduit
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','centre')
            ->select("t.type,t.id")
            ->andWhere('centre.id = :centre')
            ->setParameter('centre',$idCentre)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getOneTypeProduit($idTypeProduit)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','centre')
            ->select("t.type,t.id,centre.nom as nomCentre,centre.id as idCentre")
            ->andWhere('t.id = :centre')
            ->setParameter('centre',$idTypeProduit)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function verificationTypeProduit($typeProduit)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','centre')
            ->select("t.id")
            ->andWhere('t.type = :type')
            ->setParameter('type',$typeProduit)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
