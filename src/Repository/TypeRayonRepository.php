<?php

namespace App\Repository;

use App\Entity\TypeRayon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeRayon|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeRayon|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeRayon[]    findAll()
 * @method TypeRayon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method TypeRayon|null verificationTypeRayon($value)
 */
class TypeRayonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeRayon::class);
    }

    // /**
    //  * @return TypeRayon[] Returns an array of TypeRayon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeRayon
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function verificationTypeRayon($designation,$idCentre)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','c')
            ->select("t.id")
            ->select("t.id")
            ->andWhere('t.designation = :val')
            ->andWhere('c.id = :id')
            ->setParameters(['val'=> $designation,'id'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function getAllTypeRayon($idCentre)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','c')
            ->select("t.id,t.designation,c.nom as nomCentre, c.id as idCentre, c.adresse as adreeseCentre,c.tel as telCentre")
            ->andWhere('c.id = :id')
            ->setParameter('id', $idCentre)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneTypeRayon($idCentre,$id)
    {
        return $this->createQueryBuilder('t')
            ->join('t.centre','c')
            ->select("t.id,t.designation,c.nom as nomCentre, c.id as idCentre, c.adresse as adreeseCentre,c.tel as telCentre")
            ->andWhere('c.id = :idCentre')
            ->andWhere('t.id = :id')
            ->setParameters(['idCentre'=> $idCentre,'id'=>$id])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
