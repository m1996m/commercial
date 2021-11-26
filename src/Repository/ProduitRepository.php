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
    public function rechercherProduit($value,Centre $centre,$id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type,type.id,centre.id,centre.nom,centre.adresse')
            ->Where('p.designation = :val')
            ->orWhere('p.id=:id')
            ->andWhere('type.centre = :centre')
            ->setParameters(['val'=> $value,'centre'=>$centre,'id'=>$id])
            ->orderBy('p.designation', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

        //rechercher produit en fonction de la designation
        public function rechercherProduitID(Centre $centre,$id)
        {
            return $this->createQueryBuilder('p')
                ->join('p.type','type')
                ->join('type.centre','centre')
                ->select('p.designation,p.PUA,p.PUV,p.id,type.type,type.id,centre.id,centre.nom,centre.adresse')
                ->orWhere('p.id=:id')
                ->andWhere('type.centre = :centre')
                ->setParameters(['centre'=>$centre,'id'=>$id])
                ->orderBy('p.designation', 'ASC')
                ->getQuery()
                ->getOneOrNullResult();
        }

    //rechercher produit en fonction de la designation et du type
    public function rechercherProduitTypeDesignation($value,TypeProduit $type,Centre $centre): ?Produit
    {
            return $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type,type.id,centre.id,centre.nom,centre.adresse')
            ->Where('p.designation = :val')
            ->andWhere('p.type = :type')
            ->andWhere('centre = :centre')
            ->setParameters(['val'=> $value,'type'=>$type,'centre'=>$centre])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll(Centre $centre)
    {
        $qb= $this->createQueryBuilder('p')
            ->join('p.type','type')
            ->join('type.centre','centre')
            ->select('p.id,p.designation,p.PUA,p.PUV,type.type,type.id,centre.id,centre.nom,centre.adresse')
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
            ->select('p.designation,p.PUA,p.PUV,p.id,type.type,type.id,centre.id,centre.nom,centre.adresse')
            ->andWhere('p.id = :id')
            ->andWhere('centre = :centre')
            ->setParameters(['id'=> $id,'centre'=>$centre])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
