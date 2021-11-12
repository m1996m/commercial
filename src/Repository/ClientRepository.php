<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Client|null rechercherClient($value)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
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
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //Rechercher client
    public function rechercherClient($value)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.tel = :tel')
            ->setParameter('tel', $value)
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Rechercher client
    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->Where('c.centre = :centre')
            ->select('nom,tel,id, prenom, adresse')
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
