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
    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('c')
            ->join('c.fournisseur','f')
            ->join('c.centre','centre')
            ->select('f.slug,c.id,f.id,f.nom,f.prenom,f.tel,f.adresse,centre.nom as nomCentre,centre.id as idCentre')
            ->Where('centre.id = :centre')
            ->orderBy('f.nom', 'ASC')
            ->setParameter('centre',$idCentre)
            ->getQuery()
            ->getResult();
    }

    public function getOneFournisseur($idCentre,$slugFournisseur)
    {
        return $this->createQueryBuilder('c')
            ->join('c.fournisseur','f')
            ->join('c.centre','centre')
            ->select('f.slug,f.id as idFournisseur,c.id,f.id,f.nom,f.prenom,f.tel,f.adresse,centre.nom as nomCentre,centre.id as idCentre')
            ->Where('centre.id = :centre')
            ->andWhere('f.slug = :slug')
            ->orderBy('f.nom', 'ASC')
            ->setParameters(['centre'=>$idCentre,'slug'=>$slugFournisseur])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTel($tel,$idCentre)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre','centre')
            ->join('e.fournisseur','f')
            ->select('f.id')
            ->Where('f.tel=:tel')
            ->andWhere('centre.id=:id')
            ->setParameters(['tel'=>$tel,'id'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function rechercherClient($value,$idCentre)
    {
        return $this->createQueryBuilder('cl')
            ->join('cl.fournisseur','c')
            ->join('cl.centre','centre')
            ->select('c.nom,c.tel,c.id, c.prenom, c.adresse')
            ->Where('c.tel LIKE :tel')
            ->OrWhere('c.nom LIKE :nom')
            ->OrWhere('c.prenom LIKE :prenom')
            ->andWhere('centre.id = :idCentre')
            ->setParameterS(['tel'=> '%'.$value.'%','nom'=> '%'.$value.'%','prenom'=> '%'.$value.'%','idCentre'=> $idCentre])
            ->orderBy('c.nom', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getIdFournisseurClient($idCentre,$id)
    {
        return $this->createQueryBuilder('c')
            ->join("c.centre","centre")
            ->join("c.fournisseur","cl")
            ->select('c.id')
            ->where("centre.id=:id")
            ->andwhere("cl.id=:idCl")
            ->setParameters(["id"=>$idCentre,"idCl"=>$id])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
