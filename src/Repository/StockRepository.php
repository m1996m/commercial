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
    public function rechercherStock($nomSock)
    {
        return $this->createQueryBuilder('s')
            ->join('s.centre','centre')
            ->select("s.nom,s.adresse,s.id,centre.id as idCentre,centre.nom as nomCentre")
            ->Where('s.nom = :nom')
            ->setParameter('nom',$nomSock)
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //Recherche stock
    public function verificationNom($nomSotck,$idCentre)
    {
        return $this->createQueryBuilder('s')
            ->join('s.centre','centre')
            ->select("s.id")
            ->Where('s.nom = :nom')
            ->where('s.centre=:centre')
            ->setParameters(['nom'=>$nomSotck,'centre'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('s')
            ->join('s.centre','centre')
            ->select("s.nom,s.adresse,s.id,centre.id as idCentre,centre.nom as nomCentre")
            ->Where('centre.id = :centre')
            ->setParameter('centre', $idCentre)
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneStoke($idStock,$idCentre)
    {
        return $this->createQueryBuilder('s')
            ->join('s.centre','centre')
            ->select("s.nom,s.adresse,centre.tel as telCentre,centre.adresse as adresseCentre, s.id,centre.id as idCentre,centre.nom as nomCentre")
            ->Where('s.id = :stock')
            ->andWhere('centre.id= :centre')
            ->setParameters(['stock'=>$idStock,'centre'=>$idCentre])
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
