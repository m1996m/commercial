<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\ProduitStock;
use App\Entity\Rayon;
use App\Entity\TypeRayon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @method Rayon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rayon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rayon[]    findAll()
 * @method Rayon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
    //Permet de rechercher sur quel emplacement se trouve un produit
    public function rechercherProduit($designation,$idCentre)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.user','user')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('p.type','t')
            ->join('stock.centre','centre')
            ->select("type.designation as designationType,t.type as typeProduit,p.id as idProduit, p.designation as designationProduit,stock.id as idSock,ps.PUA as PUAProduitStock,ps.PUV as PUVProduitStock,stock.nom as designationStock, ps.id as idProduitStock, type.id as idType,centre.nom as nomCentre,r.quantite,r.id,centre.id as idCentre")
            ->orWhere('p.designation LIKE :idS')
            ->orWhere('t.type LIKE :types')
            ->andWhere('centre.id = :id')
            ->setParameters(['idS'=>'%'.$designation.'%','types'=>'%'.$designation.'%','id'=>$idCentre])
            ->orderBy('r.type', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    //Permet de rechercher les produits que contiennent un rayon ou emplacement
    public function rechercherProduitRayon($idType,$idCentre)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('stock.centre','centre')
            ->select("type.designation as designationType,p.id as idProduit, p.designation as designationProduit,stock.id as idSock,ps.PUA as PUAProduitStock,ps.PUV as PUVProduitStock,stock.nom as designationStock, ps.id as idProduitStock, type.id as idType,centre.nom as nomCentre,r.quantite,r.id,centre.id as idCentre")
            ->Where('centre.id = :idc')
            ->andWhere('type.id = :val')
            ->setParameters(['idc'=>$idCentre,'val'=>$idType])
            ->orderBy('r.type', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function etatRayon($id)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('p.type','tp')
            ->join('stock.centre','centre')
            ->select("SUM(r.quantite) as total,p.designation as designationProduit,tp.type as typeProduit,type.designation as designationType")
            ->andWhere('centre.id = :val')
            ->groupBy('p.designation,tp.type,type.designation')
            ->setParameter('val', $id)
            ->orderBy('total,p.designation,tp.type','ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('r')
            ->select("type.designation as designationType,r.prise,t.type as typeProduit,p.id as idProduit, p.designation as designationProduit,stock.id as idSock,ps.PUA as PUAProduitStock,ps.PUV as PUVProduitStock,stock.nom as designationStock, ps.id as idProduitStock, type.id as idType,centre.nom as nomCentre,r.quantite,r.id,centre.id as idCentre")
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('p.type','t')
            ->join('stock.centre','centre')
            ->Where('centre.id = :val')
            ->andWhere('r.quantite > r.prise')
            ->setParameter('val',$idCentre)
            ->orderBy('r.quantite', 'ASC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneRayon($idCentre,$id)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('stock.centre','centre')
            ->select("type.designation as designationType,p.id as idProduit, p.designation as designationProduit,stock.id as idSock,ps.PUA as PUAProduitStock,ps.PUV as PUVProduitStock,stock.nom as designationStock, ps.id as idProduitStock, type.id as idType,centre.nom as nomCentre,r.quantite,r.id,centre.id as idCentre")
            ->andWhere('centre.id = :val')
            ->andWhere('r.id = :id')
            ->setParameters(['val'=> $idCentre,'id'=>$id])
            ->orderBy('r.quantite', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    

    public function vente($id)
    {
        return $this->createQueryBuilder('r')
            ->join('r.produitStock','ps')
            ->join('ps.produit','p')
            ->join('p.type','type')
            ->select(" p.designation as produit,ps.PUV as puv,type.type")
            ->andWhere('r.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function totalQuantite($idProduit)
    {
        return $this->createQueryBuilder('r')
            ->join('r.produitStock','ps')
            ->join('ps.produit','p')
            ->join('p.type','t')
            ->select("SUM(r.quantite) as totalQuantite,SUM(r.prise) as totalprise")
            ->andWhere('p.id = :idProduit')
            ->andWhere('r.quantite > r.prise')
            ->setParameters(['idProduit'=>$idProduit])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function totaldata($idProduit)
    {
        return $this->createQueryBuilder('r')
            ->join('r.produitStock','ps')
            ->join('ps.fournisseur','f')
            ->join('ps.stock','s')
            ->join('r.type','tr')
            ->join('ps.produit','p')
            ->join('p.type','t')
            ->select("r.id as idRayon,t.type as typeProduit,tr.id as idType,p.id as idP,f.id as idf,s.id as idStock,r.quantite as quantiteRayon,r.prise")
            ->andWhere('p.id = :idProduit')
            ->andWhere('r.quantite > r.prise')
            ->andWhere('r.prise > :prise')
            ->setParameters(['idProduit'=>$idProduit,'prise'=>0])
            ->getQuery()
            ->getResult()
        ;
    }

    public function verificationQuantite($idRayon,$quantite)
    {
        return $this->createQueryBuilder('s')
            ->select("s.quantite,s.prise")
            ->Where('s.id = :id')
            ->andWhere('s.quantite <:quantite')
            ->setParameters(['id'=> $idRayon,'quantite'=>(int)'s.prise'+(int)$quantite])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getIntataneShearch($idCentre,$produit)
    {
        return $this->createQueryBuilder('r')
            ->join('r.type','type')
            ->join('r.produitStock','ps')
            ->join('ps.stock','stock')
            ->join('ps.produit','p')
            ->join('p.type','t')
            ->join('stock.centre','centre')
            ->select("type.designation as designationType,t.type as typeProduit,p.id as idProduit, p.designation as designationProduit,stock.id as idSock,ps.PUA as PUAProduitStock,ps.PUV as PUVProduitStock,stock.nom as designationStock, ps.id as idProduitStock, type.id as idType,centre.nom as nomCentre,r.quantite,r.id,centre.id as idCentre")
            ->Where('centre.id = :val')
            ->andWhere('r.quantite >= :quantite')
            ->andWhere('p.designation >= :designation')
            ->setParameters(['val'=> $idCentre,'quantite'=>(int)'s.quantite'-(int)'s.prise','designation'=>$produit])
            ->orderBy('r.quantite', 'ASC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult()
        ;
    }

}
