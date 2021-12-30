<?php

namespace App\Repository;

use App\Entity\Centre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Centre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centre[]    findAll()
 * @method Centre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Centre|null RechercherCentre(string $centre)
  */
class CentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centre::class);
    }

    // /**
    //  * @return Centre[] Returns an array of Centre objects
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
    public function findOneBySomeField($value): ?Centre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function RechercherCentre($centre)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.nom LIKE :nom')
            ->orWhere('c.tel LIKE :tel')
            ->orWhere('c.email LIKE :email')
            ->orWhere('c.pays LIKE :pays')
            ->orWhere('c.ville LIKE :ville')
            ->select('c.nom,c.tel,c.email,c.id,c.adresse,c.pays,c.ville')
            ->setParameters(['nom'=>'%'.$centre.'%','tel'=>'%'.$centre.'%','email'=>'%'.$centre.'%','pays'=>'%'.$centre.'%','ville'=>'%'.$centre.'%'])
            ->orderBy('c.nom','ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneCentre($idCentre)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.id LIKE :id')
            ->select('c.nom,c.tel,c.email,c.id,c.adresse,c.pays,c.ville')
            ->setParameters(['id'=>$idCentre])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->select('c.nom,c.tel,c.email,c.id,c.adresse,c.pays,c.ville')
            ->orderBy('c.nom','ASC')
            ->getQuery()
            ->getResult();
    }
    public function getTel($tel)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.tel=:tel')
            ->setParameter('tel', $tel)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function getemail($email)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.email=:email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
