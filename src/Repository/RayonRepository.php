<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\ProduitStock;
use App\Entity\Rayon;
use App\Entity\TypeRayon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rayon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rayon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rayon[]    findAll()
 * @method Rayon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Rayon|null rechercherProduit($produitStock)
 * @method Rayon|null rechercherProduitRayon($rayon,$centre)
 * @method Rayon|null etatRayon($centre)
 */
class RayonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rayon::class);
    }

    // /**
    //  * @return Rayon[] Returns an array of Rayon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rayon
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function rechercherProduit(ProduitStock $produitStock)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.user','user')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("type.designation,centre.nom,r.quantite,user.nom,user.prenom")
            ->andWhere('r.produitStock = :val')
            ->setParameter('val', $produitStock)
            ->orderBy('r.type', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function rechercherProduitRayon(TypeRayon $typeRayon,Centre $centre)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("type.designation,centre.nom,r.quantite")
            ->Where('centre = :centre')
            ->andWhere('r.type = :val')
            ->setParameters(['centre'=>$centre,'val'=>$typeRayon])
            ->orderBy('r.type', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function etatRayon(Centre $centre)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("type.designation,centre.nom,r.quantite")
            ->andWhere('centre = :val')
            ->setParameter('val', $centre)
            ->orderBy('r.quantite', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAll(Centre $centre)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("type.designation,centre.nom,r.quantite,r.id,centre.id")
            ->andWhere('centre = :val')
            ->setParameter('val', $centre)
            ->orderBy('r.quantite', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
