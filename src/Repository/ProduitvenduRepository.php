<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produitvendu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produitvendu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produitvendu[]    findAll()
 * @method Produitvendu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Produitvendu|null rechercherDernierObjet()
 * @method Produitvendu|null getAll()
 * @method Produitvendu|null getproduitVendu($vente,$rayon)
 * @method Produitvendu|null getOne($value)
 * @method Produitvendu|null mesVente($value)
 * @method Produitvendu|null mesAchat($value)
 * @method Produitvendu|null venteJour($value)
 * @method Produitvendu|null ventMois($value)
 * @method Produitvendu|null venteAnnuelle($value)
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

    public function rechercherDernierObjet()
    {
        return $this->createQueryBuilder('p')
            ->select("p.vente")
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getproduitVendu($id, Rayon $rayon)
    {
        return $this->createQueryBuilder('p')
            ->where("p.id=:id")
            ->Andwhere("p.rayon=:rayon")
            ->setParameters(['id'=>$id,'rayon'=>$rayon])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll()
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','type')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','tp')
            ->select("client.nom,client.prenom,produit.designation,tp.type,vente.quantite,ps.PUV,p.id,vente.id")
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOne($id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->join('produit.type','tp')
            ->select("client.nom,client.prenom,produit.designation,tp.type,vente.quantite,ps.PUV,nomRayon.designation,centre.nom,vente.createdAt,vente.id")
            ->where('p.id=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function mesvente(User $user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->join('produit.type','tp')
            ->select("client.nom,client.prenom,produit.designation,tp.type,vente.quantite,ps.PUV,nomRayon.designation,centre.nom,vente.createdAt,vente.id")
            ->where('p.user=:user')
            ->setParameter('user',$user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function mesAchat(Client $client)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->join('produit.type','tp')
            ->select("client.nom,client.prenom,produit.designation,tp.type,vente.quantite,ps.PUV,nomRayon.designation,centre.nom,vente.createdAt,vente.id")
            ->where('client=:client')
            ->setParameter('client',$client)
            ->getQuery()
            ->getResult()
        ;
    }
}
