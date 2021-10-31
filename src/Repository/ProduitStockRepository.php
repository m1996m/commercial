<?php

namespace App\Repository;

use App\Entity\ProduitStock;
use App\Entity\TypeProduit;
use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\ProduitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\Persistence\ManagerRegistry;

use function PHPSTORM_META\type;

/**
 * @method ProduitStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitStock[]    findAll()
 * @method ProduitStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ProduitStock|null getProduit($produit, $stock)
 * @method ProduitStock|null getEtatStockProduit($stock)
 */
class ProduitStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitStock::class);
    }

    // /**
    //  * @return ProduitStock[] Returns an array of ProduitStock objects
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
    public function findOneBySomeField($value): ?ProduitStock
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //Cette fonction permet de rechercher un produit dans la table produitStock en fonction du produit et le stock
    public function getProduit(Produit $produit,Stock $stock)
    {
        return $this->createQueryBuilder('p')
            //->select('p.id')
            ->Where('p.produit = :produit')
            ->andWhere('p.stock = :stock')
            ->andWhere('p.quantite > :quantite')
            ->setParameters(['produit'=> $produit,'stock'=>$stock,'quantite'=>0])
            ->getQuery()
            ->getResult()
        ;
    }

    //Etat du stock
    public function getEtatStockProduit(Stock $stock)
    {
        return $this->createQueryBuilder('p')
            ->join('p.produit','produit')
            ->join('produit.type','type')
            ->select("SUM(p.quantite) as total,produit.designation,type.type")
            ->andWhere('p.stock = :stock')
            ->groupBy('produit.designation,produit.type')
            ->setParameter('stock',$stock)
            ->getQuery()
            ->getResult()
        ;
    }
}
