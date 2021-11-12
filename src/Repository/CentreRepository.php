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
            ->Where('c.nom = :nom')
            ->orWhere('c.tel = :tel')
            ->orWhere('c.email = :email')
            ->orWhere('c.pays = :pays')
            ->orWhere('c.ville = :ville')
            ->setParameters(['nom'=>$centre,'tel'=>$centre,'email'=>$centre,'pays'=>$centre,'ville'=>$centre])
            ->orderBy('c.nom','ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->select('nom,prenom,tel,email,id,adresse,pays,ville')
            ->orderBy('c.nom','ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
