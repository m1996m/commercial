<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\FournisseurCentre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FournisseurCentre|null find($id, $lockMode = null, $lockVersion = null)
 * @method FournisseurCentre|null findOneBy(array $criteria, array $orderBy = null)
 * @method FournisseurCentre[]    findAll()
 * @method FournisseurCentre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurCentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FournisseurCentre::class);
    }

    // /**
    //  * @return FournisseurCentre[] Returns an array of FournisseurCentre objects
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
    public function findOneBySomeField($value): ?FournisseurCentre
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAll(Centre $centre)
    {
        return $this->createQueryBuilder('c')
            ->join('c.fournisseur','f')
            ->Where('c.centre = :centre')
            ->select('c.id,f.id,f.nom,f.prenom,f.tel,f.adresse')
            ->orderBy('f.nom', 'ASC')
            ->setParameter('centre',$centre)
            ->getQuery()
            ->getResult();
    }
}
