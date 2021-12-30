<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\Produit;
use App\Entity\TypeProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Produit|null rechercherProduit($value)
 * @method Produit|null rechercherProduitTypeDesignation($value,$type)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //rechercher produit en fonction de la designation
    public function rechercherProduit($value,$idCentre,$idProduit)
    {
        return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.id as idCentre,centre.nom as nomCentre,centre.adresse as adresseCentre')
            ->Where('p.designation = :val')
            ->orWhere('p.id=:id')
            ->andWhere('centre.id = :centre')
            ->setParameters(['val'=> $value,'centre'=>$idCentre,'id'=>$idProduit])
            ->orderBy('p.designation', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //rechercher produit instanement
    public function rechercherProduitInstatane($value,$idCentre)
    {
        return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.id as idCentre,centre.nom as nomCentre,centre.adresse as adresseCentre')
            ->Where('p.designation LIKE :val')
            ->orWhere('type.type LIKE :type')
            ->andWhere('centre.id = :centre')
            ->setParameters(['val'=>'%'.$value.'%' ,'type'=>'%'.$value.'%' ,'centre'=>$idCentre])
            ->orderBy('p.designation', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    //rechercher produit en fonction de la designation
    public function rechercherProduitID($idCentre,$id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.id as idCentre,centre.nom as nomCentre,centre.adresse as adresseCentre')                ->orWhere('p.id=:id')
            ->andWhere('centre.id = :centre')
            ->setParameters(['centre'=>$idCentre,'id'=>$id])
            ->orderBy('p.designation', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    //rechercher produit en fonction de la designation et du type
    public function rechercherProduitTypeDesignation($value,$idTypeProduit,$idCentre): ?Produit
    {
            return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.id as idCentre,centre.nom as nomCentre,centre.adresse as adresseCentre')            ->Where('p.designation = :val')
            ->andWhere('p.designation = :val')
            ->andWhere('type.id = :type')
            ->andWhere('centre.id = :centre')
            ->setParameters(['val'=> $value,'type'=>$idTypeProduit,'centre'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll(Centre $centre)
    {
        $qb= $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.nom as nomCentre,centre.adresse as adresseCentre')
            ->Where('type.centre = :val')
            ->setParameter('val', $centre)
            ->orderBy('p.designation', 'ASC');
            $query = $qb->getQuery();
            return $query->execute();
    }
    public function getOneProduit($id,Centre $centre)
    {
        return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type as designationTypeProduit,type.id as idTypeDesignationProduit,centre.id as idCentre,centre.nom as nomCentre,centre.adresse as adresseCentre')            ->andWhere('p.id = :id')
            ->andWhere('centre = :centre')
            ->setParameters(['id'=> $id,'centre'=>$centre])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
