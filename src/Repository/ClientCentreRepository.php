<?php

namespace App\Repository;

use App\Entity\ClientCentre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientCentre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientCentre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientCentre[]    findAll()
 * @method ClientCentre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
}
