<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fournisseur[]    findAll()
 * @method Fournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    // /**
    //  * @return Fournisseur[] Returns an array of Fournisseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fournisseur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //fournisseur
    public function rechercherFournisseur($value,$idCentre)
    {
        return $this->createQueryBuilder('c')
        ->join('c.centre','centre')
            ->select('c.nom,c.tel,c.id, c.prenom, c.adresse')
            ->Where('c.tel LIKE :tel')
            ->OrWhere('c.nom LIKE :nom')
            ->OrWhere('c.prenom LIKE :prenom')
            ->andWhere('c.centre = :idCentre')
            ->setParameterS(['tel'=> '%'.$value.'%','nom'=> '%'.$value.'%','prenom'=> '%'.$value.'%','idCentre'=> $idCentre])
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function getOneFournisseur($id)
    {
        return $this->createQueryBuilder('c')
            ->select('c.nom,c.tel,c.id, c.prenom, c.adresse')
            ->Where('c.id = :id')
            ->setParameter('id',$id)
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function getTel($tel)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.tel=:tel')
            ->setParameter('tel', $tel)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
