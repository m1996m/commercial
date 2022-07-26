<?php

namespace App\Repository;

use App\Entity\ProduitCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProduitCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitCommande[]    findAll()
 * @method ProduitCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitCommande::class);
    }

    // /**
    //  * @return ProduitCommande[] Returns an array of ProduitCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProduitCommande
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //
    public function getAllOneProduitCommande($reference)
    {
        return $this->createQueryBuilder('c')
            ->join('c.commande','commande')
            ->join('commande.produit','p')
            ->join('commande.user','u')
            ->join('u.centre','centre')
            ->join('p.type','t')
            ->select('commande.id,centre.adresse as adresseCentre,commande.createdAt,commande.reference,p.designation,t.type,p.PUV,commande.statut,commande.reference,u.nom,u.prenom,u.email,u.tel,u.cp,centre.nom as nomCentre,centre.email as emailCentre,centre.tel as telCentre,centre.cp as cpCentre,p.imagePrincipal')
            ->andWhere('commande.id = :id')
            ->setParameter('id', $reference)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOneProduitCommande($reference)
    {
        return $this->createQueryBuilder('c')
            ->join('c.commande','commande')
            ->join('c.produit','p')
            ->join('commande.user','u')
            ->join('u.centre','centre')
            ->join('p.type','t')
            ->select('commande.id,commande.createdAt,commande.reference,p.designation,t.type,p.PUV,commande.
            statut,commande.reference,u.nom,u.prenom,u.adresse,u.email,u.tel,u.cp,centre.nom as nomCentre,centre.email as emailCentre,centre.tel as telCentre,centre.cp as cpCentre,p.imagePrincipal')
            ->andWhere('c.reference = :id')
            ->setParameter('id', $reference)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function searchCommande($reference)
    {
        return $this->createQueryBuilder('c')
            ->join('c.commande','commande')
            ->join('c.produit','p')
            ->join('commande.user','u')
            ->join('u.centre','centre')
            ->join('p.type','t')
            ->select('commande.id,commande.createdAt,commande.reference,p.designation,t.type,p.PUV,commande.
            statut,commande.reference,u.nom,u.prenom,u.email,u.tel,u.cp,u.adresse,centre.nom as nomCentre,centre.email as emailCentre,centre.tel as telCentre,centre.adresse as adresseCentre,centre.cp as cpCentre,p.imagePrincipal')
            ->andWhere('commande.reference = :reference')
            ->setParameter('reference', $reference)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function idCommande($id)
    {
        return $this->createQueryBuilder('c')
            ->join('c.user','u')
            ->join("c.produit","p")
            ->select('p.id')
            ->andWhere('c.id = :id')
            ->setParameter('id',$id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
