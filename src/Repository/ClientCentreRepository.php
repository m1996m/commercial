<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\ClientCentre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientCentre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientCentre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientCentre[]    findAll()
 * @method ClientCentre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ClientCentre[]    getAll($centre)
 */
class ClientCentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientCentre::class);
    }

    // /**
    //  * @return ClientCentre[] Returns an array of ClientCentre objects
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
    public function findOneBySomeField($value): ?ClientCentre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('c')
            ->join("c.centre","centre")
            ->join("c.client","cl")
            ->select('cl.slug,centre.nom as nomCentre,cl.prenom,cl.adresse,cl.tel,cl.id,cl.nom,centre.id as idCentre')
            ->where("centre.id=:id")
            ->setParameter("id",$idCentre)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getIdFournisseurClient($idCentre,$id)
    {
        return $this->createQueryBuilder('c')
            ->join("c.centre","centre")
            ->join("c.client","cl")
            ->select('c.id')
            ->where("centre.id=:id")
            ->andwhere("cl.id=:idCl")
            ->setParameters(["id"=>$idCentre,"idCl"=>$id])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getOneClient($idCentre,$slugClient)
    {
        return $this->createQueryBuilder('c')
            ->join("c.centre","centre")
            ->join("c.client","cl")
            ->select('cl.slug,centre.nom as nomCentre,cl.prenom,cl.adresse,cl.tel,cl.id as idClient,cl.nom,centre.id as idCentre')
            ->where("centre.id=:id")
            ->andwhere("cl.slug=:idClient")
            ->setParameters(["id"=>$idCentre,'idClient'=>$slugClient])
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getTel($tel,$idCentre)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre','centre')
            ->join('e.client','client')
            ->select('client.id')
            ->Where('client.tel=:tel')
            ->andWhere('centre.id=:id')
            ->setParameters(['tel'=>$tel,'id'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function rechercherClient($value,$idCentre)
    {
        return $this->createQueryBuilder('cl')
            ->join('cl.client','c')
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
}
