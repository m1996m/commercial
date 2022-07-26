<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function MesCommande($domaine,$idUser)
    {
        return $this->createQueryBuilder('c')
            ->join('c.user','u')
            ->select('c.id,c.createdAt,c.reference,u.nom,u.prenom,u.email,c.statut')
            ->andWhere('c.domaine = :domaine')
            ->andWhere('u.id = :id')
            ->setParameters(['domaine'=>$domaine,'id'=>$idUser])
            ->getQuery()
            ->getResult()
            ;
    }
    public function idCommande($reference)
    {
        return $this->createQueryBuilder('c')
            ->join('c.user','u')
            ->select('c.id')
            ->andWhere('c.reference = :reference')
            ->setParameter('reference',$reference)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
