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
 * @method Fournisseur|null rechercherFournisseur($valeur)
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
    //Rechercher client
    public function rechercherFournisseur($value)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.tel = :tel')
            ->setParameter('tel', $value)
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
<<<<<<< HEAD
    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->Where('c.centre = :centre')
            ->select('nom,tel,id, prenom, adresse')
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult()
=======
    public function getTel($tel)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.tel=:tel')
            ->setParameter('tel', $tel)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
>>>>>>> employe
        ;
    }
}
