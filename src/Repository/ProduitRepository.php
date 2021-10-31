<?php

namespace App\Repository;

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
    public function rechercherProduit($value)
    {
        $qb= $this->createQueryBuilder('p')
            ->Where('p.designation = :val')
            ->setParameter('val', $value)
            ->orderBy('p.designation', 'ASC');
            $query = $qb->getQuery();
            return $query->execute();
    }

    //rechercher produit en fonction de la designation et du type
    public function rechercherProduitTypeDesignation($value,TypeProduit $type): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->Where('p.designation = :val')
            ->andWhere('p.type = :type')
            ->setParameters(['val'=> $value,'type'=>$type])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
