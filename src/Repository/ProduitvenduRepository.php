<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\Client;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\User;
use DateTime;
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

    public function rechercherVente($value,$idUser,$idCentre)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.user','user')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','type')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','tp')
            ->join('type.centre','centre')
            ->join('ps.stock','stock')
            ->select("p.id,rayon.id as idRayon, client.nom as nomClient,client.id idClient,client.prenom as prenomClient,produit.designation as designationProduit, produit.id as idProduit,tp.id as idTypeProduit,tp.type as designationProduitType,vente.remise,p.quantite as quantiteVendu,ps.PUV as prixVente,type.designation as designitionTypeRayon,centre.nom as nomCentre,vente.createdAt as dateVentre,vente.id as idVente")
            ->andwhere('produit.designation=:designation')
            ->setParameters(['designation'=>'%'.$value.'%'])
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getproduitVendu($id, $idRayon)
    {
        return $this->createQueryBuilder('p')
            ->join('p.rayon','rayon')
            ->where("p.id=:id")
            ->Andwhere("rayon.id=:idRayon")
            ->setParameters(['id'=>$id,'idRayon'=>$idRayon])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.type','type')
            ->join('type.centre','centre')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','tp')
            ->join('ps.stock','stock')
            ->select("p.id,rayon.id as idRayon, client.nom as nomClient,client.id idClient,client.prenom as prenomClient,produit.designation as designationProduit, produit.id as idProduit,tp.id as idTypeProduit,tp.type as designationProduitType,vente.remise,p.quantite as quantiteVendu,ps.PUV as prixVente,nomRayon.designation as designitionTypeRayon,centre.nom as nomCentre,vente.createdAt as dateVentre,vente.id as idVente")
            ->where('centre.id=:centre')
            ->setParameter('centre',$idCentre)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneVente($idProduitVendu,$idCentre)
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
            ->select("p.id,rayon.id as idRayon, client.nom as nomClient,client.id idClient,client.prenom as prenomClient,produit.designation as designationProduit, produit.id as idProduit,tp.id as idTypeProduit,tp.type as designationProduitType,vente.remise,p.quantite as quantiteVendu,ps.PUV as prixVente,nomRayon.designation as designitionTypeRayon,centre.nom as nomCentre,vente.createdAt as dateVentre,vente.id as idVente")
            ->where('p.id=:id')
            ->andwhere('centre.id=:idCentre')
            ->setParameters(['id'=>$idProduitVendu,'idCentre'=>$idCentre])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function mesvente($idUser)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.user','user')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->join('produit.type','tp')
            ->select("p.id,rayon.id as idRayon, client.nom as nomClient,client.id idClient,client.prenom as prenomClient,produit.designation as designationProduit, produit.id as idProduit,tp.id as idTypeProduit,tp.type as designationProduitType,vente.remise,p.quantite as quantiteVendu,ps.PUV as prixVente,nomRayon.designation as designitionTypeRayon,centre.nom as nomCentre,vente.createdAt as dateVentre,vente.id as idVente")
            ->where('user.id=:idUser')
            ->setParameter('idUser',$idUser)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // public function mesAchat(Client $client)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->join('p.vente','vente')
    //         ->join('vente.client','client')
    //         ->join('p.rayon','rayon')
    //         ->join('rayon.type','nomRayon')
    //         ->join('rayon.produitStock','ps')
    //         ->join('ps.produit','produit')
    //         ->join('ps.stock','stock')
    //         ->join('stock.centre','centre')
    //         ->join('produit.type','tp')
    //         ->select("p.id,client.nom as nomClient,client.id idClient,client.prenom as prenomClient,produit.designation as designationProduit, produit.id as idProduit,tp.id as idTypeProduit,tp.type as designationProduitType,vente.quantite as quantiteVendu,ps.PUV as prixVente,nomRayon.designation as designitionTypeRayon,centre.nom as Centre,vente.createdAt as dateVentre,vente.id as idVente")
    //         ->where('client=:client')
    //         ->setParameter('client',$client)
    //         ->orderBy('p.id', 'DESC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    public function caisse($idCentre,$date1,$date2)
    {
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','type')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("SUM(rayon.quantite) as quantiteVendu,produit.designation as designation,type.type as typeProduit, ps.PUA as PUA,ps.PUV as PUV")
            ->where('centre.id=:idCentre')
            ->andwhere('vente.createdAt BETWEEN :date1 AND :date2')
            ->setParameters(['idCentre'=>$idCentre,'date1'=>$date1,'date2'=>$date2])
            ->groupBy('produit.designation,type.type,ps.PUA,ps.PUV')
            ->getQuery()
            ->getResult()
        ;
    }
    public function venteAnneEncours($idCentre)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        $date=(new DateTime());
        //$date=$date->format('y');
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','type')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("SUM(p.quantite) as quantiteVendu,produit.designation as designation,type.type as typeProduit, ps.PUA as PUA,ps.PUV as PUV")
            ->where('centre.id=:idCentre')
            ->andwhere("YEAR(vente.createdAt)=:annee")
            ->setParameters(['idCentre'=>$idCentre,'annee'=>$date->format('Y')])
            ->groupBy('produit.designation,type.type,ps.PUA,ps.PUV')
            ->getQuery()
            ->getResult()
        ;
    }

    public function venteMensuelle($idCentre)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        $date=(new DateTime());
        //$date=$date->format('y');
        //dd($date->format('m'));
         //dd($date->format('M'));
        return $this->createQueryBuilder('p')
            ->join('p.vente','vente')
            ->join('vente.client','client')
            ->join('p.rayon','rayon')
            ->join('rayon.type','nomRayon')
            ->join('rayon.produitStock','ps')
            ->join('ps.produit','produit')
            ->join('produit.type','type')
            ->join('ps.stock','stock')
            ->join('stock.centre','centre')
            ->select("SUM(p.quantite) as quantiteVendu,produit.designation as designation,type.type as typeProduit, ps.PUA as PUA,ps.PUV as PUV")
            ->where('centre.id=:idCentre')
            ->andwhere("MONTH(vente.createdAt)=:annee")
            ->setParameters(['idCentre'=>$idCentre,'annee'=>$date->format('m')])
            ->groupBy('produit.designation,type.type,ps.PUA,ps.PUV')
            ->getQuery()
            ->getResult()
        ;
    }
}
